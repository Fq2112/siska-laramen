<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

$router->group(['prefix' => 'api'], function ($router) {

    $router->get('vacancies/search', [
        'uses' => 'SearchVacancyController@getSearchResult',
        'as' => 'get.search.vacancy'
    ]);

    $router->group(['prefix' => 'auth'], function ($router) {

        $router->post('login', 'AuthController@login');
        $router->post('signup', 'AuthController@signup');

        $router->group([
            'middleware' => 'auth:api'
        ], function ($router) {
            $router->get('logout', 'AuthController@logout');
            $router->get('user', 'AuthController@user');
        });

    });

    $router->group(['prefix' => 'clients', 'namespace' => 'Clients'], function ($router) {

        $router->get('provinces', [
            'uses' => 'LocationsAPIController@loadProvinces',
            'as' => 'load.provinces'
        ]);

        $router->get('cities', [
            'uses' => 'LocationsAPIController@loadCities',
            'as' => 'load.cities'
        ]);

        $router->get('locations', [
            'uses' => 'LocationsAPIController@loadLocations',
            'as' => 'load.locations'
        ]);

        $router->get('vacancies', [
            'uses' => 'VacanciesAPIController@loadVacancies',
            'as' => 'load.vacancies'
        ]);

        $router->get('vacancies/favorite', [
            'uses' => 'VacanciesAPIController@loadFavVacancies',
            'as' => 'load.fav.vacancies'
        ]);

        $router->get('vacancies/latest', [
            'uses' => 'VacanciesAPIController@loadLateVacancies',
            'as' => 'load.late.vacancies'
        ]);

    });

});
