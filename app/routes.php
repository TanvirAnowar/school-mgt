<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// special routing for specific route
Route::get('/', 'HomeController@login');
Route::post('auth', 'HomeController@authenticate');
Route::get('logout','HomeController@logout');


// Dynamic Routing with a common pattern
Route::any('{controller}/{action?}/{args?}', function($controller, $action = 'index', $args = '')
{

    $cont = "Controller";
    $notFound = "NotFound";
    $params = explode("/", $args);
    $app = app();

    $controllerName = $controller;

    $controller = explode("-",$controller);

    $controller = (count($controller) > 1) ? ucfirst($controller[0]).ucfirst($controller[1]) : ucfirst($controller[0]);				// added this line for resolving file name problem in linux hosting 
 
    if (!class_exists($controller.$cont)) {

        $controller = $notFound;
        $action = 'index';
    }

    $controller = $app->make($controller.$cont);

    $method = str_replace("-","",$action);
    if(!method_exists($controller,$method))
    {
        $controller = $notFound;
        $method = 'index';
        $controller = $app->make($controller.$cont);
    }
    
    Menu::setUri($controllerName.'/'.$action.'/'.$args);
    return $controller->callAction($method, $params);

})->where(array(
        'controller' => '[^/]+',
        'action' => '[^/]+',
        'args' => '[^?$]+'
));

