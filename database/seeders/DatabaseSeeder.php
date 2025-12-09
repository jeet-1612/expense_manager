<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create default categories
        $categories = [
            ['name' => 'Food & Dining', 'type' => 'expense', 'color' => '#ef4444'],
            ['name' => 'Transportation', 'type' => 'expense', 'color' => '#f59e0b'],
            ['name' => 'Shopping', 'type' => 'expense', 'color' => '#10b981'],
            ['name' => 'Entertainment', 'type' => 'expense', 'color' => '#8b5cf6'],
            ['name' => 'Bills & Utilities', 'type' => 'expense', 'color' => '#3b82f6'],
            ['name' => 'Salary', 'type' => 'income', 'color' => '#06b6d4'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#84cc16'],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['user_id' => $user->id]));
        }

        // Create sample expenses
        Expense::factory(20)->create([
            'user_id' => $user->id,
        ]);
    }
}