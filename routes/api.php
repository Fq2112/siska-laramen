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

/**
 *
 * JWT Auth
 */
$router->group(['prefix' => 'jwt','middleware' => 'api'], function ($router){
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->post('recover', 'AuthController@recover');
    $router->post('me', 'AuthController@me');
    $router->group(['middleware' => ['jwt.auth']], function($router) {
        $router->get('logout', 'AuthController@logout');
        $router->get('test', function(){
            return response()->json(['foo'=>'bar']);
        });

    });
});

/**
 * Route coba coba
 *
 */
//$router->group(['prefix' => 'tes', 'namespace' => 'Tes', 'middleware' => 'api'], function ($router) {
//    $router->post('login', 'AuthController@login');
//    $router->post('logout', 'AuthController@logout');
//    $router->post('refresh', 'AuthController@refresh');
//    $router->post('me', 'AuthController@me');
//
//});

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function ($router) {

    $router->get('vacancies/search', [
        'uses' => 'SearchVacancyController@getSearchResult',
        'as' => 'get.search.vacancy'
    ]);

    $router->post('feed',[
        'uses' => 'PostController@feedback',
        'as' => 'get.vacancy'
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

        $router->get('blog/types', [
            'uses' => 'BlogAPIController@loadBlogType',
            'as' => 'load.blogType'
        ]);

        $router->get('provinces', [
            'uses' => 'LocationsAPIController@loadProvinces',
            'as' => 'load.provinces'
        ]);

        $router->get('cities', [
            'uses' => 'LocationsAPIController@loadCities',
            'as' => 'load.cities'
        ]);

        $router->get('nations', [
            'uses' => 'LocationsAPIController@loadNations',
            'as' => 'load.nations'
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



        $router->get('vacancies/totalapply/{vacancy_id}', [
            'uses' => 'VacanciesAPIController@getTotalApllyVacancies',
            'as' => 'load.totalapply'
        ]);

        $router->get('vacancies/latest', [
            'uses' => 'VacanciesAPIController@loadLateVacancies',
            'as' => 'load.late.vacancies'
        ]);

        $router->get('agency/{agency_id}', [
            'uses' => 'VacanciesAPIController@getDetailAgency',
            'as' => 'load.agency'
        ]);

        $router->get('vacancies/{id}', [
            'uses' => 'VacanciesAPIController@getVacancyAgency',
            'as' => 'load.vacancies.selected'
        ]);

        $router->get('joblevel', [
            'uses' => 'JobAPIController@loadJobLevel',
            'as' => 'load.joblevel'
        ]);

        $router->get('jobtype', [
            'uses' => 'JobAPIController@loadJobType',
            'as' => 'load.jobtype'
        ]);

        $router->get('jobfunction', [
            'uses' => 'JobAPIController@loadJobFunction',
            'as' => 'load.jobfunction'
        ]);

        $router->get('industries', [
            'uses' => 'JobAPIController@loadIndustry',
            'as' => 'load.industries'
        ]);

        $router->get('paymentmethod', [
            'uses' => 'PaymentAPIController@loadPaymentMethod',
            'as' => 'load.paymentmethod'
        ]);

        $router->get('paymentcategory', [
            'uses' => 'PaymentAPIController@loadPaymentCategory',
            'as' => 'load.paymentcategory'
        ]);

        $router->get('plan', [
            'uses' => 'PaymentAPIController@loadPlan',
            'as' => 'load.paymentcategory'
        ]);

        $router->get('major', [
            'uses' => 'EducationAPIController@loadEducationMajor',
            'as' => 'load.major'
        ]);

        $router->get('degree', [
            'uses' => 'EducationAPIController@loadEducationDegree',
            'as' => 'load.degree'
        ]);



    });

});
