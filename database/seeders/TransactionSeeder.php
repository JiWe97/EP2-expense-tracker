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
        $categories = Category::all();

        // Generate 600 transactions
        foreach (range(1, 600) as $index) {
            $category = $categories->random();
            $type = $category->is_income ? 'income' : 'expense';

            Transaction::factory()->create([
                'category_id' => $category->id,
                'type' => $type,
            ]);
        }
    }
}
