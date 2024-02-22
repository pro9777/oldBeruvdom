<?php

namespace App\Models\calculator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class CalculatorValue extends Model
{
    use AsSource;
    use HasFactory;
    use Filterable;
    use Attachable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calculator_value';

    protected $fillable = [
        'id',
        'title',
        'alias',
        'price',
        'old_price',
        'final_price',
        'parent_id',
        'calculator_group_id',
        'product_id',
        'sort',
        'created_at',
        'updated_at',
    ];

    protected $allowedSorts = [
        'id',
        'title',
        'price',
        'parent_id',
        'calculator_group_id',
        'sort',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'id',
        'title',
        'price',
        'parent_id',
        'calculator_group_id',
        'sort',
        'created_at',
        'updated_at',
    ];


}
