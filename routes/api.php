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
$router->group(['prefix' => 'jwt', 'middleware' => 'api'], function ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->post('seeker', 'AuthController@seeker');
    $router->post('recover', 'AuthController@recover');
    $router->get('me', 'AuthController@me');

    $router->group(['prefix' => 'vacancy', 'namespace' => 'Api'], function ($router) {
        $router->post('apply', [
            'uses' => 'ApplicantsController@apiApply'
        ]);

        $router->post('bookmark', [
            'uses' => 'ApplicantsController@apiBookmark'
        ]);

        $router->post('abort', [
            'uses' => 'ApplicantsController@apiAbortApply'
        ]);

    });

    $router->group(['prefix' => 'profile', 'namespace' => 'Api'], function ($router) {
        $router->get('me', [
            'uses' => 'ProfileAPIController@show'
        ]);

        $router->get('personal', [
            'uses' => 'ProfileAPIController@show_personal'
        ]);

        $router->post('personal/save', [
            'uses' => 'ProfileAPIController@save_personal'
        ]);

        $router->group(['prefix' => 'edu'], function ($router) {
            $router->get('/{id}', [
                'uses' => 'ProfileAPIController@show_education'
            ]);

            $router->post('/save', [
                'uses' => 'ProfileAPIController@save_education'
            ]);

            $router->post('/update', [
                'uses' => 'ProfileAPIController@update_education'
            ]);

            $router->post('/delete/{id}', [
                'uses' => 'ProfileAPIController@delete_education'
            ]);

        });

        $router->group(['prefix' => 'exp'], function ($router) {
            $router->get('/{id}', [
                'uses' => 'ProfileAPIController@show_exp'
            ]);

            $router->post('/save', [
                'uses' => 'ProfileAPIController@save_exp'
            ]);

            $router->post('/update', [
                'uses' => 'ProfileAPIController@update_exp'
            ]);

            $router->post('/delete/{id}', [
                'uses' => 'ProfileAPIController@delete_exp'
            ]);

        });

        $router->group(['prefix' => 'organization'], function ($router) {
            $router->get('/{id}', [
                'uses' => 'ProfileAPIController@show_organization'
            ]);

            $router->post('/save', [
                'uses' => 'ProfileAPIController@save_organization'
            ]);

            $router->post('/update', [
                'uses' => 'ProfileAPIController@update_organization'
            ]);

            $router->post('/delete/{id}', [
                'uses' => 'ProfileAPIController@delete_organization'
            ]);

        });

    });


    $router->group(['middleware' => ['jwt.auth']], function ($router) {
        $router->get('logout', 'AuthController@logout');
        $router->get('test', function () {
            return response()->json(['foo' => 'bar']);
        });

    });
});

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function ($router) {

    $router->post('search', [
        'uses' => 'SearchAPICOntroller@search'
    ]);

    $router->get('vacancies/search', [
        'uses' => 'SearchVacancyController@getSearchResult',
        'as' => 'get.search.vacancy'
    ]);

    $router->post('feed', [
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

        $router->get('favorite/agency', [
            'uses' => 'VacanciesAPIController@favagency',
            'as' => 'load.agency'
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

    $router->group(['prefix' => 'partners', 'namespace' => 'Partners', 'middleware' => 'partner'], function ($router) {
        $router->get('/', 'SynchronizeController@getPartnerInfo');
        $router->post('sync', 'SynchronizeController@synchronize');

        $router->group(['prefix' => 'vacancies'], function ($router) {
            $router->post('create', 'PartnerAgencyVacancyController@createVacancies');
            $router->put('update', 'PartnerAgencyVacancyController@updateVacancies');
            $router->delete('delete', 'PartnerAgencyVacancyController@deleteVacancies');
            $router->put('agency/update', 'PartnerAgencyVacancyController@updateAgencies');
            $router->delete('agency/delete', 'PartnerAgencyVacancyController@deleteAgencies');
        });

        $router->group(['prefix' => 'seekers'], function ($router) {
            $router->post('create', 'PartnerSeekerController@createSeekers');
            $router->post('{provider}', 'PartnerSeekerController@seekersSocialite');
            $router->put('update', 'PartnerSeekerController@updateSeekers');
            $router->delete('delete', 'PartnerSeekerController@deleteSeekers');
        });
    });

});
