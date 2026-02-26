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
            'user_id' => null,
            'total' => $this->faker->randomFloat(2,10,500),
            'status' => 'completed',
            'completed_at' => now(),
        ];
    }
}
