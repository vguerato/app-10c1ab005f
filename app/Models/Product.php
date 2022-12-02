<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property string $name
 * @property string $sku
 * @property int $quantity
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'quantity'
    ];

    public function changes(): HasMany
    {
        return $this->hasMany(ProductChange::class);
    }
}
