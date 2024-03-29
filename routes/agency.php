<?php
/**
 * Created by PhpStorm.
 * User: ilham
 * Date: 8/1/2018
 * Time: 2:48 PM
 */

Route::get('agencies/{id}', [
    'middleware' => 'visitor',
    'uses' => 'Agencies\AgencyController@showProfile',
    'as' => 'agency.profile'
]);

Route::group(['prefix' => 'agency', 'namespace' => 'Agencies'], function () {

    Route::get('/', [
        'middleware' => 'visitor',
        'uses' => 'AgencyController@index',
        'as' => 'home-agency'
    ]);

    Route::post('invite/seeker', [
        'uses' => 'AgencyController@inviteSeeker',
        'as' => 'invite.seeker'
    ]);

    Route::group(['prefix' => 'job_posting'], function () {

        Route::get('{id}', [
            'middleware' => 'visitor',
            'uses' => 'AgencyController@showJobPosting',
            'as' => 'show.job.posting'
        ]);

        Route::get('vacancy_check/{id}', [
            'uses' => 'AgencyController@getVacancyCheck',
            'as' => 'get.vacancyCheck'
        ]);

        Route::get('reviewData/vacancy/{vacancy}', [
            'uses' => 'AgencyController@getVacancyReviewData',
            'as' => 'get.vacancyReviewData'
        ]);

        Route::get('reviewData/plans/{plan}', [
            'uses' => 'AgencyController@getPlansReviewData',
            'as' => 'get.plansReviewData'
        ]);

        Route::get('promo/{kode}', [
            'uses' => 'AgencyController@getPromo',
            'as' => 'get.promo'
        ]);

        Route::get('paymentMethod/{id}', [
            'uses' => 'AgencyController@getPaymentMethod',
            'as' => 'get.paymentMethod'
        ]);

        Route::post('submit', [
            'uses' => 'AgencyController@submitJobPosting',
            'as' => 'submit.job.posting'
        ]);

        Route::put('payment_proof/submit', [
            'uses' => 'AgencyController@uploadPaymentProof',
            'as' => 'upload.paymentProof'
        ]);

        Route::get('invoice/{id}', [
            'middleware' => 'visitor',
            'uses' => 'AgencyController@invoiceJobPosting',
            'as' => 'invoice.job.posting'
        ]);

        Route::get('delete/{id}', [
            'uses' => 'AgencyController@deleteJobPosting',
            'as' => 'delete.job.posting'
        ]);

    });

});

Route::group(['prefix' => 'account/agency', 'namespace' => 'Agencies'], function () {

    Route::get('profile', [
        'middleware' => 'visitor',
        'uses' => 'AccountController@editProfile',
        'as' => 'agency.edit.profile'
    ]);

    Route::post('profile/update', [
        'uses' => 'AccountController@updateProfile',
        'as' => 'agency.update.profile'
    ]);

    Route::post('profile/gallery/create', [
        'uses' => 'AccountController@createGalleries',
        'as' => 'create.galleries'
    ]);

    Route::get('profile/gallery/delete', [
        'uses' => 'AccountController@deleteGallery',
        'as' => 'agency.delete.gallery'
    ]);

    Route::get('settings', [
        'middleware' => 'visitor',
        'uses' => 'AccountController@accountSettings',
        'as' => 'agency.settings'
    ]);

    Route::put('settings/update', [
        'uses' => 'AccountController@updateAccount',
        'as' => 'agency.update.settings'
    ]);

    Route::group(['prefix' => 'vacancy'], function () {

        Route::get('status', [
            'middleware' => 'visitor',
            'uses' => 'AccountController@showVacancyStatus',
            'as' => 'agency.vacancy.status'
        ]);

        Route::get('status/vacancies', [
            'uses' => 'AccountController@getVacancyStatus',
            'as' => 'get.vacancy.status'
        ]);

        Route::get('/', [
            'middleware' => 'visitor',
            'uses' => 'AccountController@showVacancy',
            'as' => 'agency.vacancy.show'
        ]);

        Route::post('create', [
            'uses' => 'AccountController@createVacancy',
            'as' => 'agency.vacancy.create'
        ]);

        Route::get('delete/{id}/{judul}', [
            'uses' => 'AccountController@deleteVacancy',
            'as' => 'agency.vacancy.delete'
        ]);

        Route::get('edit/{id}', [
            'uses' => 'AccountController@editVacancy',
            'as' => 'agency.vacancy.edit'
        ]);

        Route::put('update/{id}', [
            'uses' => 'AccountController@updateVacancy',
            'as' => 'agency.vacancy.update'
        ]);

    });

    Route::group(['prefix' => 'dashboard'], function () {

        Route::get('application_received', [
            'middleware' => 'visitor',
            'uses' => 'AccountController@showDashboard',
            'as' => 'agency.dashboard'
        ]);

        Route::get('application_received/seekers', [
            'uses' => 'AccountController@getAccSeeker',
            'as' => 'get.acc.seeker'
        ]);

        Route::get('recommended_seeker', [
            'middleware' => 'visitor',
            'uses' => 'AccountController@recommendedSeeker',
            'as' => 'agency.recommended.seeker'
        ]);

        Route::get('recommended_seeker/seekers', [
            'uses' => 'AccountController@getRecommendedSeeker',
            'as' => 'get.recommended.seeker'
        ]);

        Route::get('recommended_seeker/{id}', [
            'uses' => 'AccountController@detailRecommendedSeeker',
            'as' => 'detail.recommended.seeker'
        ]);

        Route::get('invited_seeker', [
            'middleware' => 'visitor',
            'uses' => 'AccountController@invitedSeeker',
            'as' => 'agency.invited.seeker'
        ]);

        Route::get('invited_seeker/seekers', [
            'uses' => 'AccountController@getInvitedSeeker',
            'as' => 'get.invited.seeker'
        ]);

    });

});
