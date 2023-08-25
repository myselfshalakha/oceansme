<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Shortcodes\GetSalaryTable;
use App\Shortcodes\companyLogo;
use App\Shortcodes\companyTitle;
use Shortcode;

class ShortcodesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
		Shortcode::register('GetSalaryTable', GetSalaryTable::class);
		Shortcode::register('companyLogo', companyLogo::class);
		Shortcode::register('companyTitle', companyTitle::class);
		
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
