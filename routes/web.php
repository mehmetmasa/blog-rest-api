<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
$router->post('admin/login', 'AdminController@login');


$router->group(['prefix' => 'api'], function () use ($router)
{
    $router->group(['prefix' => 'admin', 'middleware' => 'auth'], function ($router)
    {
       $router->group(['prefix' => 'categories'], function () use ($router)
       {
           $router->get('/',  ['uses' => 'CategoryController@showAllCategory']);
           $router->get('/{id}',  ['uses' => 'CategoryController@showOneCategory']);
           $router->post('/',  ['uses' => 'CategoryController@create']);
           $router->put('/{id}',  ['uses' => 'CategoryController@update']);
           $router->delete('/{id}',  ['uses' => 'CategoryController@delete']);
       });
    });
});

