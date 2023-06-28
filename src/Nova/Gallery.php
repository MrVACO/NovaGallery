<?php

declare(strict_types = 1);

namespace MrVaco\NovaGallery\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use MrVaco\NovaGallery\Models\Gallery as GalleryModel;
use MrVaco\NovaStatusesManager\Classes\StatusClass;
use MrVaco\NovaStatusesManager\Fields\Status;

class Gallery extends Resource
{
    public static $displayInNavigation = false;
    
    public static string $model = GalleryModel::class;
    
    public static $title = 'name';
    
    public static $search = [
        'name', 'year'
    ];
    
    public static function uriKey(): string
    {
        return 'gallery';
    }
    
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(),
            
            Text::make('Name')
                ->rules('required')
                ->fullWidth(),
            
            Textarea::make('Description')
                ->rows(2)
                ->fullWidth(),
            
            Status::make(__('Status'), 'status')
                ->rules('required')
                ->options(StatusClass::LIST('full'))
                ->default(StatusClass::ACTIVE()->id)
                ->sortable()
                ->fullWidth(),
        ];
    }
}
