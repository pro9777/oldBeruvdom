<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    use HasFactory;
    protected $table = 'orders_products';
    protected $casts = [
        'attributes' => 'array',
    ];
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'qty',
        'attributes',
        'created_at',
        'updated_at',
    ];
}
