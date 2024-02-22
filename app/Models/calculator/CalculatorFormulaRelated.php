<?php

namespace App\Models\calculator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatorFormulaRelated extends Model
{
    use HasFactory;

    protected $fillable = [
        'calculator_formulas_id',
        'product_id',
    ];
}
