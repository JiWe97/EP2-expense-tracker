<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Fetch existing categories from the database
        $categories = Category::where('user_id', 1)->get();

        // Generate 600 transactions
        foreach (range(1, 600) as $index) {
            $category = $categories->random();
            $type = $category->is_income ? 'income' : 'expense';

            // Generate a random amount
            $amount = $category->is_income ? rand(100, 1000) : -rand(100, 1000);

            Transaction::factory()->create([
                'category_id' => $category->id,
                'type' => $type,
                'amount' => $amount,
            ]);
        }
    }
}
