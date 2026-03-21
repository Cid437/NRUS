<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Product::updateOrCreate(
            ['slug' => $row['slug'] ?? Str::slug($row['name'])],
            [
                'name' => $row['name'],
                'description' => $row['description'] ?? null,
                'price' => $row['price'] ?? 0,
                'stock' => $row['stock'] ?? 0,
                'is_active' => $row['is_active'] ?? 1,
                'category_id' => $row['category_id'] ?? null,
                'brand_id' => $row['brand_id'] ?? null,
            ]
        );
    }
}