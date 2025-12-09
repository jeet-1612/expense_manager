<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Monthly summary
        $monthlyExpenses = Expense::where('user_id', $userId)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');
        
        // Category-wise expenses
        $categories = Category::where('user_id', $userId)
            ->with(['expenses' => function($query) {
                $query->whereMonth('date', now()->month)
                      ->whereYear('date', now()->year);
            }])
            ->get();
        
        // Recent expenses
        $recentExpenses = Expense::where('user_id', $userId)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();
        
        // Monthly trend (last 6 months)
        $monthlyTrend = Expense::where('user_id', $userId)
            ->select(
                DB::raw('MONTH(date) as month'),
                DB::raw('YEAR(date) as year'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'monthlyExpenses',
            'categories',
            'recentExpenses',
            'monthlyTrend'
        ));
    }
}