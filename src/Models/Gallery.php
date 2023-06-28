<?php

namespace MrVaco\NovaGallery\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';
    
    protected $fillable = [
        'name',
        'description',
        'images',
        'year',
        'status',
    ];
    
    protected $casts = [
        'images' => 'array',
        'year'   => 'integer'
    ];
}
