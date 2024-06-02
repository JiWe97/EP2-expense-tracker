<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Beauty', 'color' => '#FF69B4', 'icon' => 'fas fa-paint-brush'],
            ['name' => 'Car', 'color' => '#1E90FF', 'icon' => 'fas fa-car'],
            ['name' => 'Family & Personal', 'color' => '#FFD700', 'icon' => 'fas fa-users'],
            ['name' => 'Food & Drink', 'color' => '#FF6347', 'icon' => 'fas fa-utensils'],
            ['name' => 'Gifts & Donations', 'color' => '#FF4500', 'icon' => 'fas fa-gift'],
            ['name' => 'Groceries', 'color' => '#32CD32', 'icon' => 'fas fa-shopping-basket'],
            ['name' => 'Healthcare', 'color' => '#8B4513', 'icon' => 'fas fa-heartbeat'],
            ['name' => 'Education', 'color' => '#4682B4', 'icon' => 'fas fa-book'],
            ['name' => 'Travel', 'color' => '#2E8B57', 'icon' => 'fas fa-plane'],
            ['name' => 'Bills & Fees', 'color' => '#D3D3D3', 'icon' => 'fas fa-file-invoice-dollar'],
            ['name' => 'Shopping', 'color' => '#FF69B4', 'icon' => 'fas fa-shopping-cart'],
            ['name' => 'Sport & Hobbies', 'color' => '#32CD32', 'icon' => 'fas fa-football-ball'],
            ['name' => 'Other', 'color' => '#FFD700', 'icon' => 'fas fa-ellipsis-h'],
            ['name' => 'Pets', 'color' => '#8B4513', 'icon' => 'fas fa-paw'],
            ['name' => 'Home & Garden', 'color' => '#1E90FF', 'icon' => 'fas fa-home'],
            ['name' => 'Entertainment', 'color' => '#FF4500', 'icon' => 'fas fa-film'],
            ['name' => 'Transportation', 'color' => '#4682B4', 'icon' => 'fas fa-bus'],
            ['name' => 'Insurance', 'color' => '#2E8B57', 'icon' => 'fas fa-shield-alt'],
            ['name' => 'Work', 'color' => '#D3D3D3', 'icon' => 'fas fa-briefcase']
        ];

        DB::table('categories')->insert($categories);
    }
}
