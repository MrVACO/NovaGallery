<?php

declare(strict_types = 1);

namespace MrVaco\NovaGallery\Http\Controllers;

use App\Http\Controllers\Controller;
use MrVaco\NovaGallery\Models\Gallery;
use MrVaco\NovaGallery\Resources\GalleryResource;

class GalleryController extends Controller
{
    public function show(Gallery $gallery, int $id)
    {
        $data = $gallery->where('id', $id)->firstOrFail();
        
        abort_if(!$data, 404);
        
        return GalleryResource::make($data);
    }
}
