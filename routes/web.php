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

$router->get('/', ['as' => 'index',  function () {
        return view('index');
}
]);

$router->get('domains', [
    'as' => 'domains.index', 'uses' => 'DomainsController@index'
]);

$router->get('domains/{id}', [
    'as' => 'domains.show', 'uses' => 'DomainsController@show'
]);

$router->delete('domains/{id}', [
    'as' => 'domains.destroy', 'uses' => 'DomainsController@destroy'
]);

$router->post('domains', [
    'as' => 'domains.store', 'uses' => 'DomainsController@store'
]);
