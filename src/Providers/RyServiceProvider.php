<?php

namespace Ry\Laravel\Providers;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RyServiceProvider extends ServiceProvider
{
	/**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
    	parent::boot($router);
    	/*
    	$this->publishes([    			
    			__DIR__.'/../config/rylaravel.php' => config_path('rylaravel.php')
    	], "config");  
    	$this->mergeConfigFrom(
	        	__DIR__.'/../config/rylaravel.php', 'rylaravel'
	    );
    	$this->publishes([
    			__DIR__.'/../assets' => public_path('vendor/rylaravel'),
    	], "public");    	
    	*/
    	//ressources
    	$this->loadViewsFrom(__DIR__.'/../ressources/views', 'rylaravel');
    	$this->loadTranslationsFrom(__DIR__.'/../ressources/lang', 'rylaravel');
    	/*
    	$this->publishes([
    			__DIR__.'/../ressources/views' => resource_path('views/vendor/rylaravel'),
    			__DIR__.'/../ressources/lang' => resource_path('lang/vendor/rylaravel'),
    	], "ressources");
    	*/
    	$this->publishes([
    			__DIR__.'/../database/factories/' => database_path('factories'),
	        	__DIR__.'/../database/migrations/' => database_path('migrations')
	    ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
    public function map(Router $router)
    {    	
    	if (! $this->app->routesAreCached()) {
    		$router->group(['namespace' => 'Ry\Laravel\Http\Controllers'], function(){
    			require __DIR__.'/../Http/routes.php';
    		});
    	}
    }
}