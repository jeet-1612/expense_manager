<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'category_id',
        'date',
        'description',
        'payment_method',
        'user_id'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    // Relationship: An expense belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: An expense belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Accessor for formatted date
    public function getFormattedDateAttribute()
    {
        return $this->date->format('d M, Y');
    }

    // Accessor for formatted amount
    public function getFormattedAmountAttribute()
    {
        return '₹' . number_format($this->amount, 2);
    }

    // Scope for user's expenses
    public function scopeForUser($query, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $query->where('user_id', $userId);
    }

    // Scope for expenses between dates
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    // Scope for expenses by category
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}