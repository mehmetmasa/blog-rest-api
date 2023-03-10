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
$router->post('login', 'AuthorController@login');
$router->post('register', 'AuthorController@register');

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

        $router->group(['prefix' => 'articles'], function () use ($router)
        {
            $router->get('/',  ['uses' => 'ArticleController@showAllArticle']);
            $router->get('/{id}',  ['uses' => 'ArticleController@showOneArticle']);
            $router->post('/',  ['uses' => 'ArticleController@create']);
            $router->put('/{id}',  ['uses' => 'ArticleController@update']);
        });

        $router->group(['prefix' => 'authors'], function () use ($router)
        {
            $router->get('/',  ['uses' => 'AuthorController@showAllAuthor']);
            $router->get('/{id}',  ['uses' => 'AuthorController@showOneAuthor']);
            $router->post('/',  ['uses' => 'AuthorController@create']);
            $router->put('/{id}',  ['uses' => 'AuthorController@update']);
            $router->delete('/{id}',  ['uses' => 'AuthorController@delete']);
        });
    });
});

