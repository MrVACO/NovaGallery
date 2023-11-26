<?php

declare(strict_types = 1);

namespace MrVaco\NovaGallery\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use MrVaco\NovaGallery\Models\Gallery;

class GalleryYearFilter extends Filter
{
    public function name(): string
    {
        return __('Filter by year');
    }
    
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where('year', $value);
    }
    
    public function options(NovaRequest $request): array
    {
        $years = Gallery::query()->pluck('year');
        
        return Arr::sortDesc(array_unique($years->toArray()));
    }
}