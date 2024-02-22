<?php

namespace App\Models\Category;

use App\Models\calculator\CalculatorGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatorGroupRelated extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'calculator_group_id',
        'category_id',
        'product_id',
    ];

}
