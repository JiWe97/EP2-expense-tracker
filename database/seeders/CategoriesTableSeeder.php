<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param int $userId
     * @return void
     */
    public function run(int $userId): void
    {
        $categories = [
            ['name' => 'Beauty', 'color' => '#FF69B4', 'icon' => 'fas fa-paint-brush', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Car', 'color' => '#1E90FF', 'icon' => 'fas fa-car', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Family & Personal', 'color' => '#FFD700', 'icon' => 'fas fa-users', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Food & Drink', 'color' => '#FF6347', 'icon' => 'fas fa-utensils', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Gifts & Donations', 'color' => '#FF4500', 'icon' => 'fas fa-gift', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Groceries', 'color' => '#32CD32', 'icon' => 'fas fa-shopping-basket', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Healthcare', 'color' => '#8B4513', 'icon' => 'fas fa-heartbeat', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Education', 'color' => '#4682B4', 'icon' => 'fas fa-book', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Travel', 'color' => '#2E8B57', 'icon' => 'fas fa-plane', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Bills & Fees', 'color' => '#D3D3D3', 'icon' => 'fas fa-file-invoice-dollar', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Shopping', 'color' => '#FF69B4', 'icon' => 'fas fa-shopping-cart', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Sport & Hobbies', 'color' => '#32CD32', 'icon' => 'fas fa-football-ball', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Other', 'color' => '#FFD700', 'icon' => 'fas fa-ellipsis-h', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Pets', 'color' => '#8B4513', 'icon' => 'fas fa-paw', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Home & Garden', 'color' => '#1E90FF', 'icon' => 'fas fa-home', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Entertainment', 'color' => '#FF4500', 'icon' => 'fas fa-film', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Transportation', 'color' => '#4682B4', 'icon' => 'fas fa-bus', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Insurance', 'color' => '#2E8B57', 'icon' => 'fas fa-shield-alt', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Work', 'color' => '#D3D3D3', 'icon' => 'fas fa-briefcase', 'is_income' => false, 'user_id' => $userId],
            ['name' => 'Wages', 'color' => '#FF5733', 'icon' => 'fas fa-money-bill-wave', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Invoices', 'color' => '#33FF57', 'icon' => 'fas fa-file-invoice-dollar', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Interest', 'color' => '#3357FF', 'icon' => 'fas fa-percentage', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Dividends', 'color' => '#FF33A8', 'icon' => 'fas fa-chart-line', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Sales', 'color' => '#FFA833', 'icon' => 'fas fa-shopping-cart', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Rental income', 'color' => '#A833FF', 'icon' => 'fas fa-home', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Contributions & subsidies', 'color' => '#33FFF5', 'icon' => 'fas fa-hand-holding-usd', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Checks & coupons', 'color' => '#FF33E2', 'icon' => 'fas fa-ticket-alt', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Lottery', 'color' => '#FFC733', 'icon' => 'fas fa-ticket-alt', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Gambling', 'color' => '#57FF33', 'icon' => 'fas fa-dice', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Reimbursement (tax, purchase)', 'color' => '#FF3333', 'icon' => 'fas fa-receipt', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Child benefit', 'color' => '#33D1FF', 'icon' => 'fas fa-baby', 'is_income' => true, 'user_id' => $userId],
            ['name' => 'Gifts', 'color' => '#FF5733', 'icon' => 'fas fa-gift', 'is_income' => true, 'user_id' => $userId],
        ];

        DB::table('categories')->insert($categories);
    }
}
