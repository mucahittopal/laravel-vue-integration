<?php

namespace App\Providers;

use App\Country;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials._appheader', function ($view) {
            $countries = Country::orderBy('name', 'asc')->get();
            $country_change_links_in_url = [];
            foreach ($countries as $country){
                $country_change_links_in_url[] = change_search_country($country->id);
            }

            $view->with([
                'countries' => $countries,
                'country_change_links_in_url' => $country_change_links_in_url
            ]);
        });
    }
}
