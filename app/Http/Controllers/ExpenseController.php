<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of expenses.
     * URL: GET /expenses
     * Route Name: expenses.index
     * View: expenses.index
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get filter parameters
        $filters = [
            'from_date' => request('from_date'),
            'to_date' => request('to_date'),
            'category_id' => request('category_id'),
            'search' => request('search'),
            'payment_method' => request('payment_method')
        ];

        // Start query
        $query = Expense::where('user_id', $userId)
            ->with('category')
            ->latest();

        // Apply filters
        if ($filters['from_date']) {
            $query->where('date', '>=', $filters['from_date']);
        }
        
        if ($filters['to_date']) {
            $query->where('date', '<=', $filters['to_date']);
        }
        
        if ($filters['category_id']) {
            $query->where('category_id', $filters['category_id']);
        }
        
        if ($filters['search']) {
            $query->where(function($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        if ($filters['payment_method']) {
            $query->where('payment_method', $filters['payment_method']);
        }

        // Get paginated results
        $expenses = $query->paginate(15);
        
        // Get totals
        $totalExpenses = Expense::where('user_id', $userId)->sum('amount');
        $filteredTotal = $query->sum('amount');
        
        // Get categories for filter dropdown
        $categories = Category::where('user_id', $userId)->get();
        
        // Get payment methods for filter dropdown
        $paymentMethods = Expense::where('user_id', $userId)
            ->select('payment_method')
            ->distinct()
            ->pluck('payment_method');

        return view('expenses.index', compact(
            'expenses',
            'totalExpenses',
            'filteredTotal',
            'categories',
            'paymentMethods',
            'filters'
        ));
    }

    /**
     * Show the form for creating a new expense.
     * URL: GET /expenses/create
     * Route Name: expenses.create
     * View: expenses.create
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();
            
        // Default payment methods
        $paymentMethods = [
            'cash' => 'Cash',
            'credit_card' => 'Credit Card', 
            'debit_card' => 'Debit Card',
            'bank_transfer' => 'Bank Transfer',
            'upi' => 'UPI',
            'other' => 'Other'
        ];

        return view('expenses.create', compact('categories', 'paymentMethods'));
    }

    /**
     * Store a newly created expense in storage.
     * URL: POST /expenses
     * Route Name: expenses.store
     * Redirects to: expenses.index
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'payment_method' => 'required|string|in:cash,credit_card,debit_card,bank_transfer,upi,other',
            'description' => 'nullable|string|max:1000'
        ]);

        // Add user_id to validated data
        $validated['user_id'] = Auth::id();

        // Create expense
        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense added successfully!');
    }

    /**
     * Display the specified expense.
     * URL: GET /expenses/{expense}
     * Route Name: expenses.show
     * View: expenses.show
     */
    public function show(Expense $expense)
    {
        // Check if expense belongs to user
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        // Load related data
        $expense->load('category');
        
        // Get similar expenses (same category, last 30 days)
        $similarExpenses = Expense::where('user_id', Auth::id())
            ->where('category_id', $expense->category_id)
            ->where('id', '!=', $expense->id)
            ->where('date', '>=', now()->subDays(30))
            ->latest()
            ->take(5)
            ->get();

        return view('expenses.show', compact('expense', 'similarExpenses'));
    }

    /**
     * Show the form for editing the specified expense.
     * URL: GET /expenses/{expense}/edit
     * Route Name: expenses.edit
     * View: expenses.edit
     */
    public function edit(Expense $expense)
    {
        // Check if expense belongs to user
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();
            
        $paymentMethods = [
            'cash' => 'Cash',
            'credit_card' => 'Credit Card',
            'debit_card' => 'Debit Card',
            'bank_transfer' => 'Bank Transfer',
            'upi' => 'UPI',
            'other' => 'Other'
        ];

        return view('expenses.edit', compact('expense', 'categories', 'paymentMethods'));
    }

    /**
     * Update the specified expense in storage.
     * URL: PUT/PATCH /expenses/{expense}
     * Route Name: expenses.update
     * Redirects to: expenses.index
     */
    public function update(Request $request, Expense $expense)
    {
        // Check if expense belongs to user
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'payment_method' => 'required|string|in:cash,credit_card,debit_card,bank_transfer,upi,other',
            'description' => 'nullable|string|max:1000'
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove the specified expense from storage.
     * URL: DELETE /expenses/{expense}
     * Route Name: expenses.destroy
     * Redirects to: expenses.index
     */
    public function destroy(Expense $expense)
    {
        // Check if expense belongs to user
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully!');
    }

    /**
     * Export expenses to CSV (Optional extra feature)
     */
    public function export(Request $request)
    {
        $userId = Auth::id();
        
        $expenses = Expense::where('user_id', $userId)
            ->with('category')
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="expenses_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($expenses) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['Date', 'Title', 'Amount', 'Category', 'Payment Method', 'Description']);
            
            // Add data rows
            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->date->format('Y-m-d'),
                    $expense->title,
                    $expense->amount,
                    $expense->category->name,
                    ucfirst($expense->payment_method),
                    $expense->description
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get expenses statistics (Optional extra feature)
     */
    public function statistics()
    {
        $userId = Auth::id();
        
        // Monthly totals for current year
        $monthlyData = Expense::where('user_id', $userId)
            ->whereYear('date', date('Y'))
            ->select(
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy(DB::raw('MONTH(date)'))
            ->orderBy('month')
            ->get();

        // Category-wise totals for current month
        $categoryData = Category::where('user_id', $userId)
            ->with(['expenses' => function($query) {
                $query->whereMonth('date', date('m'))
                      ->whereYear('date', date('Y'));
            }])
            ->get()
            ->map(function($category) {
                return [
                    'name' => $category->name,
                    'total' => $category->expenses->sum('amount'),
                    'color' => $category->color
                ];
            })
            ->where('total', '>', 0);

        // Payment method distribution
        $paymentData = Expense::where('user_id', $userId)
            ->whereMonth('date', date('m'))
            ->whereYear('date', date('Y'))
            ->select('payment_method', DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->get();

        return view('expenses.statistics', compact('monthlyData', 'categoryData', 'paymentData'));
    }
}