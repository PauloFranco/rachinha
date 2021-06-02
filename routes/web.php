<?php

use Illuminate\Support\Facades\Route;
/** @var \Illuminate\Routing\Router $router */


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->get( '/', [ 'uses' => 'GamesController@index', 'as' => 'home' ] );

$router->resource( 'users', 'UsersController' );

$router->resource( 'games', 'GamesController' );

