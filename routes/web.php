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

    $router->group(['prefix' => 'staff-category', 'middleware' => 'auth'], function ($router) {
        $router->post('add', 'StaffCategoryController@add');
        $router->put('update/{id}', 'StaffCategoryController@update');
        $router->get('get', 'StaffCategoryController@get');
        $router->get('view', 'StaffCategoryController@view');
    });

    $router->group(['prefix' => 'staff-position', 'middleware' => 'auth'], function ($router) {
        $router->post('add', 'StaffPositionController@add');
        $router->put('update/{id}', 'StaffPositionController@update');
        $router->get('get', 'StaffPositionController@get');
        $router->get('view', 'StaffPositionController@view');
    });

    $router->group(['prefix' => 'programmes', 'middleware' => 'auth'], function ($router) {
        $router->post('add', 'ProgrammeController@add');
        $router->put('update/{id}', 'ProgrammeController@update');
        $router->get('get', 'ProgrammeController@get');
        $router->get('view', 'ProgrammeController@view');
    });

    $router->group(['prefix' => 'settings', 'middleware' => 'auth'], function ($router) {
        $router->post('add-update', 'SettingController@addOrUpdate');
        $router->get('get', 'SettingController@get');
        $router->get('view', 'SettingController@view');
    });

    $router->group(['prefix' => 'staff', 'middleware' => 'auth'], function ($router) {
        $router->post('add', 'StaffController@add');
        $router->put('update/{id}', 'StaffController@update');
        $router->get('get', 'StaffController@get');
        $router->get('view', 'StaffController@view');
        $router->get('get-staff-id', 'StaffController@getWithStaffID');
        $router->get('get-staff-category', 'StaffController@getWithCategory');
        $router->get('get-staff-position', 'StaffController@getWithPosition');
        $router->get('get-staff-category-position', 'StaffController@getWithCategoryAndPosition');
        $router->get('get-staff-certificate', 'StaffController@getWithCertificate');
        $router->delete('delete/{id}', 'StaffController@delete');
        $router->post('import', 'StaffController@import');
    });

    $router->group(['prefix' => 'departments', 'middleware' => 'auth'], function ($router) {
        $router->post('add', 'DepartmentController@add');
        $router->put('update/{id}', 'DepartmentController@update');
        $router->get('get', 'DepartmentController@get');
        $router->get('view', 'DepartmentController@view');
    });

    $router->group(['prefix' => 'courses', 'middleware' => 'auth'], function ($router) {
        $router->post('add', 'CourseController@add');
        $router->put('update/{id}', 'CourseController@update');
        $router->get('get', 'CourseController@get');
        $router->get('view', 'CourseController@view');
        $router->get('get-department', 'CourseController@getWithDepartment');
        $router->get('get-semester', 'CourseController@getWithSemester');
        $router->post('import', 'CourseController@import');
    });

});


