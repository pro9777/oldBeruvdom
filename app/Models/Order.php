<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Order extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;

    protected $table = 'orders';

    protected $fillable = [
        'id_order',
        'user_id',
        'name',
        'number',
        'email',
        'surname',
        'comment',
        'created_at',
        'updated_at',
    ];

    protected $allowedSorts = [
        'id_order',
        'user_id',
        'name',
        'number',
        'email',
        'surname',
        'comment',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'id_order',
        'user_id',
        'name',
        'number',
        'email',
        'surname',
        'comment',
        'created_at',
        'updated_at',
    ];

    public function products(){
        return $this->hasMany(OrderProducts::class, 'order_id');
    }
}
