<?php

namespace App\Http\Middleware;

use App\Models\Aplikasi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AplikasiData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $title = Aplikasi::first();
        $footer = Aplikasi::first();
        $favicon = Aplikasi::first();
        $logo = Aplikasi::first();
        $sidebar = Aplikasi::first();

        view()->share('title', $title);
        view()->share('footer', $footer);
        view()->share('favicon', $favicon);
        view()->share('logo', $logo);
        view()->share('sidebar', $sidebar);

        return $next($request);
    }
}
