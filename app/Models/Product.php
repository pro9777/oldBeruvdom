<?php

namespace App\Models;

use App\Models\calculator\CalculatorFormula;
use App\Models\calculator\CalculatorFormulaRelated;
use App\Models\calculator\CalculatorGroup;
use App\Models\calculator\CalculatorValue;
use App\Models\Category\CalculatorGroupRelated;
use Hamcrest\Core\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $title название
 * @property string $alias псевдоним
 * @property int|null $price цена
 * @property int|null $old_price старая цена
 * @property string|null $brend бренд
 * @property string|null $collection Коллекция
 * @property string|null $new Новинки
 * @property string|null $articular артикул
 * @property string|null $products_like связанные товары
 * @property int|null $parent_id родительсткая категория
 * @property string|null $keywords ключевые слова
 * @property string|null $description описание
 * @property string|null $description2 Описание2
 * @property int $sort сортировка
 * @property string|null $hits Хиты продаж
 * @property string|null $seo_h1 seo H1
 * @property string|null $seo_title seo название
 * @property string|null $seo_description seo описание
 * @property string|null $seo_keywords seo ключевые слова
 * @property string|null $seo_text seo текст
 * @property string|null $blueprints_text Текст чертежей
 * @property string $status статус
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $measurement Еденица измерения
 * @property-read CalculatorFormula|null $calculator_formula
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CalculatorGroup> $calculator_group
 * @property-read int|null $calculator_group_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CalculatorGroupRelated> $calculator_group_related
 * @property-read int|null $calculator_group_related_count
 * @property-read CalculatorValue|null $calculator_group_value
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CalculatorValue> $calculator_value
 * @property-read int|null $calculator_value_count
 * @property-read \App\Models\Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|Product defaultSort(string $column, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Product filters(?mixed $kit = null, ?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product filtersApplySelection($class)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereArticular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBlueprintsText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMeasurement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOldPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductsLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;


    protected $fillable = [
        'title',
        'alias',
        'price',
        'show_price',
        'old_price',
        'brend',
        'collection',
        'NEW',
        'articular',
        'products_like',
        'parent_id',
        'keywords',
        'description',
        'description2',
        'sort',
        'hits',
        'seo_h1',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'seo_text',
        'blueprints_text',
        'status',
        'created_at',
        'updated_at',
        'measurement'
    ];

    protected $allowedSorts = [
        'id',
        'title',
        'alias',
        'price',
        'old_price',
        'brend',
        'collection',
        'image',
        'parent_id',
        'sort',
        'status',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'id',
        'title',
        'alias',
        'price',
        'old_price',
        'brend',
        'collection',
        'image',
        'parent_id',
        'sort',
        'status',
        'description',
        'created_at',
        'updated_at',
    ];

    public function setArticularAttribute($value)
    {
        $this->attributes['articular'] = str_replace(' ', '', $value);
    }

    public function calculator_group_related()
    {
        return $this->hasMany(CalculatorGroupRelated::class, 'product_id');
    }
    public function calculator_group()
    {
        return $this->hasManyThrough(
            CalculatorGroup::class,
            CalculatorGroupRelated::class,
            'product_id', // Внешний ключ в таблице CalculatorGroupRelated...
            'id', // Внешний ключ в таблице CalculatorGroup...
            'id', // Локальный ключ в таблице Product...
            'calculator_group_id' // Локальный ключ в таблице CalculatorGroupRelated...
        );
    }

    public function calculator_group_value()
    {
        return $this->hasOneThrough(
            CalculatorValue::class,
            CalculatorGroup::class,
            'id', // Внешний ключ в таблице CalculatorGroup...
            'calculator_group_id', // Внешний ключ в таблице CalculatorValue...
            'id', // Локальный ключ в таблице Product...
            'id' // Локальный ключ в таблице CalculatorGroupRelated...

        );
    }



    public function calculator_value()
    {
        return $this->hasMany(CalculatorValue::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function calculator_formula()
    {
        return $this->hasOneThrough(
            CalculatorFormula::class,
            CalculatorFormulaRelated::class,
            'product_id', // Внешний ключ в таблице CalculatorGroupRelated...
            'id', // Внешний ключ в таблице CalculatorGroup...
            'id', // Локальный ключ в таблице Product...
            'calculator_formulas_id' // Локальный ключ в таблице CalculatorGroupRelated...
        );
    }



}
