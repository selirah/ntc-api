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

$router->group(['prefix' => 'api/v1'], function ($router) {
    // auth
    $router->group(['prefix' => 'auth'], function ($router) {
        $router->post('sign-up', 'UserController@register');
        $router->post('account-verification', 'UserController@accountVerification');
        $router->post('resend-code', 'UserController@resendCode');
        $router->post('reset-password', 'UserController@resetPassword');
        $router->post('login', 'UserController@login');
    });

    $router->group(['prefix' => 'colleges', 'middleware' => 'auth'], function ($router) {
        $router->get('get', 'CollegeController@get');
        $router->post('add', 'CollegeController@add');
        $router->put('update/{id}', 'CollegeController@update');
        $router->delete('delete/{id}', 'CollegeController@delete');
        $router->get('view', 'CollegeController@view');
    });

});


