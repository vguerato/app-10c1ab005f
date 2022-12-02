<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property int $product_id
 * @property string $action
 * @property array $source_data
 * @property array $affected_data
 * @property-read string $created_at
 */
class ProductChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'action',
        'source_data',
        'affected_data'
    ];
}
