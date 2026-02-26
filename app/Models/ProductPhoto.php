<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string|null $file
 * @property bool $is_primary
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 */
class ProductPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','file','is_primary'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
