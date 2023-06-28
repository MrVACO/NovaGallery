<?php

namespace MrVaco\NovaGallery\Http\Middleware;

use Illuminate\Http\Response;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use MrVaco\NovaGallery\NovaGallery;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request                  $request
     * @param  \Closure(\Illuminate\Http\Request):mixed  $next
     *
     * @return Response
     */
    public function handle($request, $next): Response
    {
        $tool = collect(Nova::registeredTools())->first([$this, 'matchesTool']);
        
        return optional($tool)->authorize($request) ? $next($request) : abort(403);
    }
    
    /**
     * Determine whether this tool belongs to the package.
     *
     * @param  Tool  $tool
     *
     * @return bool
     */
    public function matchesTool(Tool $tool): bool
    {
        return $tool instanceof NovaGallery;
    }
}
