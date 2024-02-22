<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Page extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = [
        'title',
        'subtitle',
        'alias',
        'text',
        'seo_h1',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'seo_text',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $allowedSorts = [
        'title',
        'subtitle',
        'alias',
        'text',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
        'subtitle',
        'alias',
        'text',
        'status',
        'created_at',
        'updated_at',
    ];
}
