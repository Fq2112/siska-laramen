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

        Route::group(['prefix' => 'admins'], function () {

            Route::get('/', [
                'uses' => 'AdminController@showAdminsTable',
                'as' => 'table.admins'
            ]);

            Route::get('{id}/detail', [
                'uses' => 'AdminController@detailAdmins',
                'as' => 'detail.admins'
            ]);

            Route::post('create', [
                'uses' => 'AdminController@createAdmins',
                'as' => 'create.admins'
            ]);

            Route::put('{id}/update', [
                'uses' => 'AdminController@updateAdmins',
                'as' => 'update.admins'
            ]);

            Route::get('{id}/delete', [
                'uses' => 'AdminController@deleteAdmins',
                'as' => 'delete.admins'
            ]);

        });

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

        Route::group(['prefix' => 'requirements'], function () {

            Route::group(['prefix' => 'degrees'], function () {

                Route::get('/', [
                    'uses' => 'AdminController@showDegreesTable',
                    'as' => 'table.degrees'
                ]);

                Route::post('create', [
                    'uses' => 'AdminController@createDegrees',
                    'as' => 'create.degrees'
                ]);

                Route::put('{id}/update', [
                    'uses' => 'AdminController@updateDegrees',
                    'as' => 'update.degrees'
                ]);

                Route::get('{id}/delete', [
                    'uses' => 'AdminController@deleteDegrees',
                    'as' => 'delete.degrees'
                ]);

            });

            Route::group(['prefix' => 'majors'], function () {

                Route::get('/', [
                    'uses' => 'AdminController@showMajorsTable',
                    'as' => 'table.majors'
                ]);

                Route::post('create', [
                    'uses' => 'AdminController@createMajors',
                    'as' => 'create.majors'
                ]);

                Route::put('{id}/update', [
                    'uses' => 'AdminController@updateMajors',
                    'as' => 'update.majors'
                ]);

                Route::get('{id}/delete', [
                    'uses' => 'AdminController@deleteMajors',
                    'as' => 'delete.majors'
                ]);

            });

            Route::group(['prefix' => 'industries'], function () {

                Route::get('/', [
                    'uses' => 'AdminController@showIndustriesTable',
                    'as' => 'table.industries'
                ]);

                Route::post('create', [
                    'uses' => 'AdminController@createIndustries',
                    'as' => 'create.industries'
                ]);

                Route::put('{id}/update', [
                    'uses' => 'AdminController@updateIndustries',
                    'as' => 'update.industries'
                ]);

                Route::get('{id}/delete', [
                    'uses' => 'AdminController@deleteIndustries',
                    'as' => 'delete.industries'
                ]);

            });

        });

    });

});