<?php

namespace MrVaco\NovaGallery\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'mrvaco_gallery';
    
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
    
    public function imagesCount(): int|string
    {
        return !empty($this->images) && count(json_decode($this->images)) > 0 ? count(json_decode($this->images)) : "—";
    }
}
