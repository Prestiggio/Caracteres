<?php
namespace Ry\Caracteres\Providers;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Ry\Caracteres\Models\Characteristiclang;
use Ry\Caracteres\Models\Characteristic;

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
    	
    	$router->bind("characteristic", function($value){
    		return Characteristiclang::where("path", "=", $value)->first()->characteristic;
    	});
    	
    	/*
    	$this->publishes([    			
    			__DIR__.'/../config/rycaracteres.php' => config_path('rycaracteres.php')
    	], "config");  
    	
    	$this->mergeConfigFrom(
	        	__DIR__.'/../config/rycaracteres.php', 'rycaracteres'
	    );
    	
    	$this->publishes([
    			__DIR__.'/../assets' => public_path('vendor/rycaracteres'),
    	], "public");    	
    	*/
    	
    	//ressources
    	$this->loadViewsFrom(__DIR__.'/../ressources/views', 'rycaracteres');
    	$this->loadTranslationsFrom(__DIR__.'/../ressources/lang', 'rycaracteres');
    	
    	/*
    	$this->publishes([
    			__DIR__.'/../ressources/views' => resource_path('views/vendor/rycaracteres'),
    			__DIR__.'/../ressources/lang' => resource_path('lang/vendor/rycaracteres'),
    	], "ressources");
    	*/
    	
    	$this->publishes([
	        	__DIR__.'/../database/migrations/' => database_path('migrations')
	    ], 'migrations');
    	
    	Characteristic::saved(function($characteristic){
    		foreach ($characteristic->terms as $term)
    			$term->makepath();
    	});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    public function map(Router $router)
    {
    	if (! $this->app->routesAreCached()) {
    		$router->group(['namespace' => 'Ry\Caracteres\Http\Controllers'], function(){
    			require __DIR__.'/../Http/routes.php';
    		});
    	}
    }
}
