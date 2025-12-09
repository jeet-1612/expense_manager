<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'color',
        'description',
        'user_id'
    ];

    // Relationship: A category belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A category has many expenses
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Accessor for display color (fallback to default)
    public function getDisplayColorAttribute()
    {
        return $this->color ?? '#3b82f6'; // Default blue color
    }

    // Scope for expense categories
    public function scopeExpenseCategories($query)
    {
        return $query->where('type', 'expense');
    }

    // Scope for income categories
    public function scopeIncomeCategories($query)
    {
        return $query->where('type', 'income');
    }

    // Scope for user's categories
    public function scopeForUser($query, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $query->where('user_id', $userId);
    }
}