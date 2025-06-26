<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Models\Categoria\Categoria;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('es');

         View::composer('*', function ($view) {
        $view->with('categorias', Categoria::all());



        View::composer('*', function ($view) {
            $data = $view->getData();

            if (!array_key_exists('imagenesPublicidad', $data)) {
                $view->with('imagenesPublicidad', collect());
            }

            if (!array_key_exists('imagenesBanner', $data)) {
                $view->with('imagenesBanner', collect());
            }
        });

    });

    
    }
    

    

}
