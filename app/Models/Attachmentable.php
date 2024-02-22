<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachmentable extends Model
{
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'attachmentable';

    protected $fillable = [
        'attachmentable_type',
        'attachmentable_id',
        'attachment_id',
    ];
}
