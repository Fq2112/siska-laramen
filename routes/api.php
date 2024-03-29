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
$router->group(['prefix' => 'jwt'], function ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->post('seeker', 'AuthController@seeker');
    $router->post('recover', 'AuthController@recover');
    $router->get('me', 'AuthController@me');

    $router->group(['prefix' => 'vacancy', 'namespace' => 'Api'], function ($router) {
        $router->get('{id}/detail', [
            'uses' => 'ApplicantsController@getDetail',
            'as' => 'load.vacancies.selected'
        ]);

        $router->post('update/password', [
            'uses' => 'ApplicantsController@update_pass'
        ]);

        $router->post('applying', [
            'uses' => 'ApplicantsController@apiApply'
        ]);

        $router->post('bookmarking', [
            'uses' => 'ApplicantsController@apiBookmark'
        ]);

        $router->post('abort', [
            'uses' => 'ApplicantsController@apiAbortApply'
        ]);

        $router->post('apply', [
            'uses' => 'ApplicantsController@show_apply'
        ]);

        $router->post('bookmark', [
            'uses' => 'ApplicantsController@show_bookmark'
        ]);

        $router->post('invitation', [
            'uses' => 'ApplicantsController@show_invitation'
        ]);

        $router->post('invitation/accept', [
            'uses' => 'ApplicantsController@accept_invitation'
        ]);
    });

    $router->group(['prefix' => 'profile', 'namespace' => 'Api'], function ($router) {

        $router->get('me', [
            'uses' => 'ProfileAPIController@show'
        ]);

        $router->get('show/edu', [
            'uses' => 'ProfileAPIController@get_edu'
        ]);

        $router->get('show/exp', [
            'uses' => 'ProfileAPIController@get_exp'
        ]);

        $router->get('show/org', [
            'uses' => 'ProfileAPIController@get_org'
        ]);

        $router->get('show/training', [
            'uses' => 'ProfileAPIController@get_training'
        ]);

        $router->get('show/skill', [
            'uses' => 'ProfileAPIController@get_skill'
        ]);

        $router->get('show/lang', [
            'uses' => 'ProfileAPIController@get_lang'
        ]);

        $router->get('personal', [
            'uses' => 'ProfileAPIController@show_personal'
        ]);

        $router->post('personal/save', [
            'uses' => 'ProfileAPIController@save_personal'
        ]);

        $router->post('contact/save', [
            'uses' => 'ProfileAPIController@save_contact'
        ]);

        $router->post('upload/ava', [
            'uses' => 'ProfileAPIController@uploadAva'
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

        $router->group(['prefix' => 'training'], function ($router) {
            $router->get('/{id}', [
                'uses' => 'ProfileAPIController@show_training'
            ]);

            $router->post('/save', [
                'uses' => 'ProfileAPIController@save_training'
            ]);

            $router->post('/update', [
                'uses' => 'ProfileAPIController@update_training'
            ]);

            $router->post('/delete/{id}', [
                'uses' => 'ProfileAPIController@delete_training'
            ]);

        });

        $router->group(['prefix' => 'lang'], function ($router) {
            $router->get('/{id}', [
                'uses' => 'ProfileAPIController@show_lang'
            ]);

            $router->post('/save', [
                'uses' => 'ProfileAPIController@save_lang'
            ]);

            $router->post('/update', [
                'uses' => 'ProfileAPIController@update_lang'
            ]);

            $router->post('/delete/{id}', [
                'uses' => 'ProfileAPIController@delete_lang'
            ]);

        });

        $router->group(['prefix' => 'skill'], function ($router) {
            $router->get('/{id}', [
                'uses' => 'ProfileAPIController@show_skill'
            ]);

            $router->post('/save', [
                'uses' => 'ProfileAPIController@save_skill'
            ]);

            $router->post('/update', [
                'uses' => 'ProfileAPIController@update_skill'
            ]);

            $router->post('/delete/{id}', [
                'uses' => 'ProfileAPIController@delete_skill'
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

    $router->get('vacancies/search/{keyword}', [
        'uses' => 'SearchVacancyController@getKeywordVacancy',
        'as' => 'get.keyword.vacancy'
    ]);

    $router->post('feed', [
        'uses' => 'PostController@feedback',
        'as' => 'get.vacancy'
    ]);

    $router->group(['prefix' => 'midtrans'], function ($router) {

        $router->get('snap', [
            'uses' => 'MidtransController@snap',
            'as' => 'get.midtrans.snap'
        ]);

        $router->group(['prefix' => 'callback'], function ($router) {

            $router->get('finish', [
                'uses' => 'MidtransController@finishCallback',
                'as' => 'get.midtrans-callback.finish'
            ]);

            $router->get('unfinish', [
                'uses' => 'MidtransController@unfinishCallback',
                'as' => 'get.midtrans-callback.unfinish'
            ]);

            $router->get('error', [
                'uses' => 'MidtransController@errorCallback',
                'as' => 'get.midtrans-callback.error'
            ]);

            $router->post('payment', [
                'uses' => 'MidtransController@notificationCallback',
                'as' => 'post.midtrans-callback.notification'
            ]);

        });

    });

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

        $router->get('vacancies/get/{limit}', [
            'uses' => 'VacanciesAPIController@loadVacanciesMobile',
            'as' => 'load.vacancies.mobile'
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

        $router->get('vacancies/{id}/detail', [
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

        $router->get('salaries', [
            'uses' => 'JobAPIController@loadSalaries',
            'as' => 'load.salaries'
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
