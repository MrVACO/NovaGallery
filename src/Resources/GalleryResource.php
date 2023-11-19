<?php

declare(strict_types = 1);

namespace MrVaco\NovaGallery\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \MrVaco\NovaGallery\Models\Gallery */
class GalleryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'images'      => $this->resource->images ? json_decode($this->resource->images) : null,
            'year'        => $this->year,
            'created_at'  => $this->created_at,
        ];
    }
}
