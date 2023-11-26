<?php

declare(strict_types = 1);

namespace MrVaco\NovaGallery\Nova;

use Ayvazyan10\Imagic\Imagic;
use Carbon\Carbon;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;
use MrVaco\NovaGallery\Filters\GalleryYearFilter;
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
        return $this->fieldsArray($request);
    }
    
    public function fieldsForCreate(NovaRequest $request): array
    {
        return [
            Panel::make(__('Create gallery'), $this->fieldsArray($request))
        ];
    }
    
    public function fieldsForDetail(NovaRequest $request): array
    {
        return [
            Panel::make(__(':resource Details: :title', [
                'resource' => '',
                'title'    => $this->title()
            ]), $this->fieldsArray($request))
        ];
    }
    
    public function fieldsForUpdate(NovaRequest $request): array
    {
        return [
            Panel::make(__('Update :resource: :title', [
                'resource' => '',
                'title'    => $this->title()
            ]), $this->fieldsArray($request))
        ];
    }
    
    public function fieldsArray(NovaRequest $request): array
    {
        return [
            ID::make()
                ->sortable(),
            
            Text::make(__('Name'), 'name')
                ->rules('required')
                ->sortable(),
            
            Textarea::make(__('Description'), 'description')
                ->rows(2)
                ->sortable(),
            
            Number::make(__('Count images'))
                ->displayUsing(function()
                {
                    return $this->imagesCount();
                })
                ->textAlign('center')
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            
            Imagic::make(__('Images'), 'images')
                ->multiple()
                ->directory(sprintf('galleries/%s', Carbon::now()->format("Y-m-d")))
                ->convert(false)
                ->hideFromIndex()
                ->hideFromDetail(),
            
            Status::make(__('Status'), 'status')
                ->rules('required')
                ->options(StatusClass::LIST('full'))
                ->default(StatusClass::ACTIVE()->id)
                ->sortable()
                ->col()
                ->forSecondary(),
            
            Select::make(__('Year'), 'year')
                ->options($this->yearsArray($this->year | null))
                ->default(Carbon::now()->year)
                ->fillUsing(function($request, $model, $attribute)
                {
                    if ($request->{$attribute} == null)
                        $model->{$attribute} = Carbon::now()->year;
                    else
                        $model->{$attribute} = $request->{$attribute};
                })
                ->help(__('The Default Is The Current Year'))
                ->sortable()
                ->col()
                ->forSecondary(),
        ];
    }
    
    public static function label(): string
    {
        return __('Gallery');
    }
    
    public static function createButtonLabel(): string
    {
        return __('Create');
    }
    
    protected function yearsArray(int $current_year = null): array
    {
        if (empty($current_year))
            $current_year = Carbon::now()->year;
        
        $list = range(Carbon::now()->addYear()->year, Carbon::now()->addYear(-3)->year);
        
        if (!in_array($current_year, $list))
            $list[$current_year] = $current_year;
        
        return array_combine($list, $list);
    }
    
    public static function redirectAfterCreate(NovaRequest $request, $resource): string
    {
        return '/resources/' . static::uriKey();
    }
    
    public static function redirectAfterDelete(NovaRequest $request): string
    {
        return '/resources/' . static::uriKey();
    }
    
    public static function redirectAfterUpdate(NovaRequest $request, $resource): string
    {
        return '/resources/' . static::uriKey();
    }
    
    public function filters(NovaRequest $request): array
    {
        return [
            new GalleryYearFilter
        ];
    }
}
