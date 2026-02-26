<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 */
class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
