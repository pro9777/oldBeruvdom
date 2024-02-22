<?php

namespace App\Models;

use App\Models\calculator\CalculatorGroup;
use App\Models\calculator\CalculatorValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $title название
 * @property string $alias псевдоним
 * @property string|null $image фотография
 * @property int|null $parent_id родительсткая категория
 * @property string|null $stati связанные статьи
 * @property string|null $keywords ключевые слова
 * @property string|null $description описание
 * @property string|null $blueprints_text Текст чертежей
 * @property int $sort сортировка
 * @property string $status статус
 * @property string|null $seo_h1 seo H1
 * @property string|null $seo_title seo название
 * @property string|null $seo_description seo описание
 * @property string|null $seo_keywords seo ключевые слова
 * @property string|null $seo_text seo текст
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CalculatorGroup> $calculator_group
 * @property-read int|null $calculator_group_count
 * @property-read CalculatorGroup|null $calculator_value
 * @method static \Illuminate\Database\Eloquent\Builder|Category defaultSort(string $column, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Category filters(?mixed $kit = null, ?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Category filtersApplySelection($class)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereBlueprintsText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStati($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use AsSource;
    use HasFactory;
    use Filterable;
    use Attachable;
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;


    protected $fillable = [
        'title',
        'alias',
        'image',
        'parent_id',
        'keywords',
        'description',
        'sort',
        'blueprints_text',
        'seo_h1',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'seo_text',
        'stati',
        'created_at',
        'updated_at',
    ];

    protected $allowedSorts = [
        'id',
        'title',
        'alias',
        'image',
        'parent_id',
        'stati',
        'keywords',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
        'alias',
        'image',
        'parent_id',
        'keywords',
        'description',
        'created_at',
        'updated_at',
    ];

    public function calculator_group(){
        return $this->hasMany(CalculatorGroup::class, 'product_id');
    }

    public function calculator_value()
    {
        return $this->hasOneThrough(
            CalculatorGroup::class,
            CalculatorValue::class,
            'calculator_group_id', // Внешний ключ в таблице `cars` ...
            'id' // Внешний ключ в таблице `owners` ...
        );
    }

//    public function catigories()
//    {
//        return $this->hasMany(Category::class, 'parent_id');
//    }
    public function products()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }

}

