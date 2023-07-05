<?php

declare(strict_types = 1);

namespace MrVaco\NovaGallery\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin \MrVaco\NovaGallery\Models\Gallery */
class GalleryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'images'      => $this->getImages() ?? null,
            'year'        => $this->year,
            'created_at'  => $this->created_at,
        ];
    }
    
    protected function getImages(): array
    {
        $images = [];
        
        foreach ($this->images as $image)
        {
            $images[] = Storage::disk('public')->url($image['attributes']['image']);
        }
        
        return $images;
    }
}
