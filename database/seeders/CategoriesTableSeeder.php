<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $user_id): void
    {
        $categories = [
            ['name' => 'Beauty', 'color' => '#FF69B4', 'icon' => 'fas fa-paint-brush', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Car', 'color' => '#1E90FF', 'icon' => 'fas fa-car', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Family & Personal', 'color' => '#FFD700', 'icon' => 'fas fa-users', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Food & Drink', 'color' => '#FF6347', 'icon' => 'fas fa-utensils', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Gifts & Donations', 'color' => '#FF4500', 'icon' => 'fas fa-gift', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Groceries', 'color' => '#32CD32', 'icon' => 'fas fa-shopping-basket', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Healthcare', 'color' => '#8B4513', 'icon' => 'fas fa-heartbeat', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Education', 'color' => '#4682B4', 'icon' => 'fas fa-book', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Travel', 'color' => '#2E8B57', 'icon' => 'fas fa-plane', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Bills & Fees', 'color' => '#D3D3D3', 'icon' => 'fas fa-file-invoice-dollar', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Shopping', 'color' => '#FF69B4', 'icon' => 'fas fa-shopping-cart', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Sport & Hobbies', 'color' => '#32CD32', 'icon' => 'fas fa-football-ball', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Other', 'color' => '#FFD700', 'icon' => 'fas fa-ellipsis-h', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Pets', 'color' => '#8B4513', 'icon' => 'fas fa-paw', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Home & Garden', 'color' => '#1E90FF', 'icon' => 'fas fa-home', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Entertainment', 'color' => '#FF4500', 'icon' => 'fas fa-film', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Transportation', 'color' => '#4682B4', 'icon' => 'fas fa-bus', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Insurance', 'color' => '#2E8B57', 'icon' => 'fas fa-shield-alt', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Work', 'color' => '#D3D3D3', 'icon' => 'fas fa-briefcase', 'is_income' => false, 'user_id' => $user_id],
            ['name' => 'Wages', 'color' => '#FF5733', 'icon' => 'fas fa-money-bill-wave', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Invoices', 'color' => '#33FF57', 'icon' => 'fas fa-file-invoice-dollar', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Interest', 'color' => '#3357FF', 'icon' => 'fas fa-percentage', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Dividends', 'color' => '#FF33A8', 'icon' => 'fas fa-chart-line', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Sales', 'color' => '#FFA833', 'icon' => 'fas fa-shopping-cart', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Rental income', 'color' => '#A833FF', 'icon' => 'fas fa-home', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Contributions & subsidies', 'color' => '#33FFF5', 'icon' => 'fas fa-hand-holding-usd', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Checks & coupons', 'color' => '#FF33E2', 'icon' => 'fas fa-ticket-alt', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Lottery', 'color' => '#FFC733', 'icon' => 'fas fa-ticket-alt', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Gambling', 'color' => '#57FF33', 'icon' => 'fas fa-dice', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Reimbursement (tax, purchase)', 'color' => '#FF3333', 'icon' => 'fas fa-receipt', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Child benefit', 'color' => '#33D1FF', 'icon' => 'fas fa-baby', 'is_income' => true, 'user_id' => $user_id],
            ['name' => 'Gifts', 'color' => '#FF5733', 'icon' => 'fas fa-gift', 'is_income' => true, 'user_id' => $user_id],
        ];

        DB::table('categories')->insert($categories);
    }
}
