<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'category_id' => Category::inRandomOrder()->first()->id,
            'date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'description' => $this->faker->sentence(),
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card', 'debit_card', 'upi']),
            'user_id' => User::factory(),
        ];
    }
}