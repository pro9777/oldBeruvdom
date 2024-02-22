<?php

namespace App\Models\calculator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatorFormula extends Model
{
    use HasFactory;

    protected $fillable = [
        'formula',
        'categories_id',
        'product_id',
        'sort',
        ];

    public function scopeFormula(Builder $query, $category_id)
    {

        return static::where('categories_id', $category_id);
    }
}
