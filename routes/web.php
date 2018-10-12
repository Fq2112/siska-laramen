<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register universal routes (non-role) for SISKA.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

Auth::routes();

Route::group(['prefix' => '/'], function () {

    Route::get('info', [
        'uses' => 'UserController@infoSISKA',
        'as' => 'info.siska'
    ]);

    Route::post('/', [
        'uses' => 'UserController@postContact',
        'as' => 'contact.submit'
    ]);

});

Route::group(['namespace' => 'Auth', 'prefix' => 'account'], function () {

    Route::post('login', [
        'uses' => 'LoginController@login',
        'as' => 'login'
    ]);

    Route::post('logout', [
        'uses' => 'LoginController@logout',
        'as' => 'logout'
    ]);

    Route::get('activate', [
        'uses' => 'ActivationController@activate',
        'as' => 'activate'
    ]);

    Route::get('login/{provider}', [
        'uses' => 'SocialAuthController@redirectToProvider',
        'as' => 'redirect'
    ]);

    Route::get('login/{provider}/callback', [
        'uses' => 'SocialAuthController@handleProviderCallback',
        'as' => 'callback'
    ]);

});

Route::group(['namespace' => 'Admins', 'prefix' => 'admin'], function () {

    Route::get('/', [
        'uses' => 'AdminController@index',
        'as' => 'home-admin'
    ]);

    Route::get('inbox', [
        'uses' => 'AdminController@showInbox',
        'as' => 'admin.inbox'
    ]);

    Route::group(['prefix' => 'tables'], function () {

        Route::group(['prefix' => 'users'], function () {

            Route::get('/', [
                'uses' => 'AdminController@showUsersTable',
                'as' => 'table.users'
            ]);

            Route::get('{id}/detail', [
                'uses' => 'AdminController@detailUsers',
                'as' => 'detail.users'
            ]);

            Route::get('{id}/delete', [
                'uses' => 'AdminController@deleteUsers',
                'as' => 'delete.users'
            ]);

        });
    });

});