<?php

namespace Database\Factories;

use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionItemFactory extends Factory
{
    protected $model = TransactionItem::class;

    public function definition()
    {
        return [
            'transaction_id' => null,
            'product_id' => null,
            'quantity' => 1,
            'unit_price' => 0,
        ];
    }
}
