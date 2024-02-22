<?php

namespace App\Models\calculator;

use http\Env\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class CalculatorGroup extends Model
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
    protected $table = 'calculator_group';

    protected $fillable = [
        'id',
        'title',
        'product_id',
        'type',
        'category_id',
        'col_outside',
        'col',
        'hide',
        'col_inside',
        'name',
        'active_slider',
        'required',
        'sort',
        'created_at',
        'updated_at',
    ];

    protected $allowedSorts = [
        'id',
        'title',
        'name',
        'sort',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'id',
        'title',
        'name',
        'sort',
        'created_at',
        'updated_at',
    ];

    public function calculator_value(){
        return $this->hasMany(CalculatorValue::class, 'calculator_group_id');
    }

    public function group_related(){
        return $this->hasMany(CalculatorValue::class, 'product_id');
    }


    public function calculator_group_value()
    {
        return $this->belongsToMany(
            CalculatorValue::class,
            'product_id',
            'calculator_value',
            'id',
            'id',
            'id'

        );
    }


    public function scopeGroup(Builder $query)
    {

        return static::all();
    }
}
