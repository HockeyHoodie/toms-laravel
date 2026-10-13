<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'demo@example.com')->firstOrFail();

        $transactions = [
            [
                'title' => 'Monthly salary',
                'amount' => 1200.00,
                'type' => 'income',
                'category' => 'Salary',
                'days_ago' => 12,
            ],
            [
                'title' => 'Freelance website',
                'amount' => 250.00,
                'type' => 'income',
                'category' => 'Freelance',
                'days_ago' => 8,
            ],
            [
                'title' => 'Weekly groceries',
                'amount' => 45.50,
                'type' => 'expense',
                'category' => 'Food',
                'days_ago' => 6,
            ],
            [
                'title' => 'Bus ticket',
                'amount' => 1.50,
                'type' => 'expense',
                'category' => 'Transport',
                'days_ago' => 5,
            ],
            [
                'title' => 'Monthly rent',
                'amount' => 350.00,
                'type' => 'expense',
                'category' => 'Housing',
                'days_ago' => 4,
            ],
            [
                'title' => 'Cinema tickets',
                'amount' => 18.00,
                'type' => 'expense',
                'category' => 'Entertainment',
                'days_ago' => 3,
            ],
            [
                'title' => 'Pharmacy',
                'amount' => 12.50,
                'type' => 'expense',
                'category' => 'Health',
                'days_ago' => 2,
            ],
            [
                'title' => 'Restaurant',
                'amount' => 24.00,
                'type' => 'expense',
                'category' => 'Food',
                'days_ago' => 1,
            ],
        ];

        foreach ($transactions as $item) {
            $category = Category::where('user_id', $user->id)
                ->where('name', $item['category'])
                ->firstOrFail();

            $date = Carbon::today()->subDays($item['days_ago'])
                ->toDateString();

            Transaction::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $item['title'],
                    'date' => $date,
                ],
                [
                    'category_id' => $category->id,
                    'amount' => $item['amount'],
                    'type' => $item['type'],
                ]
            );
        }
    }
}
