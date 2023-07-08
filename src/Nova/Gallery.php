<?php

declare(strict_types = 1);

namespace MrVaco\NovaGallery\Nova;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use MrVaco\NovaGallery\Models\Gallery as GalleryModel;
use MrVaco\NovaStatusesManager\Classes\StatusClass;
use MrVaco\NovaStatusesManager\Fields\Status;
use Whitecube\NovaFlexibleContent\Flexible;

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
            
            Text::make(__('Name'), 'name')
                ->rules('required')
                ->fullWidth(),
            
            Textarea::make(__('Description'), 'description')
                ->rows(2)
                ->sortable(),
            
            Status::make(__('Status'), 'status')
                ->rules('required')
                ->options(StatusClass::LIST('full'))
                ->default(StatusClass::ACTIVE()->id)
                ->sortable()
                ->fullWidth(),
            
            Number::make(__('Count images'))
                ->displayUsing(function()
                {
                    return $this->imagesCount();
                })
                ->textAlign('center')
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            
            Flexible::make(__('Images'), 'images')
                ->addLayout(__('Image'), 'layout_image', [
                    Image::make(__('Image'), 'image')
                        ->disk('public')
                        ->path(
                            sprintf('/galleries/%s', Carbon::now()->format("Y-m-d"))
                        )
                        ->preview(function($value, $disk)
                        {
                            return $value
                                ? Storage::disk($disk)->url($value)
                                : null;
                        })
                        ->fullWidth(),
                ])
        ];
    }
    
    public static function label(): string
    {
        return __('Gallery');
    }
}
