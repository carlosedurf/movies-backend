<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

// $router->get('/', 'HomeController@index');

$router->group(['prefix'=>'v1'], function() use($router){

    $router->get('/', 'HomeController@index');

    $router->get('/genres',  'HomeController@genres');

    $router->get('/movie/{movie}',  'HomeController@movie');

    $router->get('/search',  'HomeController@search');

});


