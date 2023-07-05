<?php

declare(strict_types = 1);

use MrVaco\NovaGallery\Http\Controllers\GalleryController;

app('router')
    ->controller(GalleryController::class)
    ->group(function()
    {
        app('router')->get('{id}', 'show');
    });
