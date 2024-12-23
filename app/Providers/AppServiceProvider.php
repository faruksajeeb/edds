<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        // $data = Mrpermission::where('status', 1)->get();
        $data = Permission::select('group_name')->where(['status'=>1,'guard_name'=>'web','is_menu'=>'yes'])->groupBy('group_name')->get();

        view()->share('menu_groups', $data);
        if ( Cache::has('company_settings') ) {
            # get from file cache
            $companySettings = Cache::get('company_settings');
        }else{
            # get from database
            $companySettings = DB::table('company_settings')->first();    
            Cache::put('company_settings', $companySettings);     
        }   
        view()->share('company_settings', $companySettings);

        if ( Cache::has('theme_settings') ) {
            # get from file cache
            $themeSettings = Cache::get('theme_settings');
        }else{
            # get from database
            $themeSettings = DB::table('theme_settings')->first();    
            Cache::put('theme_settings', $themeSettings);     
        }   
        view()->share('theme_settings', $themeSettings);
    }
}
