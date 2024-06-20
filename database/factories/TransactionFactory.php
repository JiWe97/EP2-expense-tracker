<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'category_id' => null,  // This will be set in the seeder
            'user_id' => 1,
            'description' => $this->faker->sentence,
            'banking_record_id' => 1,
            'type' => null,  // This will be set in the seeder
            'valuta' => 'EUR',
            'payoff_id' => null,
        ];
    }
}
