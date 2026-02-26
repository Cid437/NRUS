<?php

namespace Database\Factories;

use App\Models\ProductPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPhotoFactory extends Factory
{
    protected $model = ProductPhoto::class;

    public function definition()
    {
        return [
            'product_id' => null,
            'file' => null,
            'is_primary' => false,
        ];
    }
}
