<?php
/**
 * Created by PhpStorm.
 * User: ilham
 * Date: 8/1/2018
 * Time: 2:48 PM
 */

Route::get('agencies/{id}', [
    'uses' => 'Agencies\AgencyController@showProfile',
    'as' => 'agency.profile'
]);

Route::group(['prefix' => 'agency', 'namespace' => 'Agencies'], function () {

    Route::get('/', [
        'uses' => 'AgencyController@index',
        'as' => 'home-agency'
    ]);

    Route::get('download/seeker-attachments/{files}', [
        'uses' => 'AgencyController@downloadSeekerAttachments',
        'as' => 'download.seeker.attachments'
    ]);

    Route::post('invite/seeker', [
        'uses' => 'AgencyController@inviteSeeker',
        'as' => 'invite.seeker'
    ]);

    Route::get('job_posting/{id}', [
        'uses' => 'AgencyController@showJobPosting',
        'as' => 'show.job.posting'
    ]);

    Route::get('job_posting/reviewData/vacancy/{vacancy}', [
        'uses' => 'AgencyController@getVacancyReviewData',
        'as' => 'get.vacancyReviewData'
    ]);

    Route::get('job_posting/reviewData/plans/{plan}', [
        'uses' => 'AgencyController@getPlansReviewData',
        'as' => 'get.plansReviewData'
    ]);

    Route::get('job_posting/paymentMethod/{id}', [
        'uses' => 'AgencyController@getPaymentMethod',
        'as' => 'get.paymentMethod'
    ]);

    Route::post('job_posting/submit', [
        'uses' => 'AgencyController@submitJobPosting',
        'as' => 'submit.job.posting'
    ]);

    Route::put('job_posting/payment_proof/submit', [
        'uses' => 'AgencyController@uploadPaymentProof',
        'as' => 'upload.paymentProof'
    ]);

    Route::get('job_posting/invoice/{id}', [
        'uses' => 'AgencyController@invoiceJobPosting',
        'as' => 'invoice.job.posting'
    ]);

    Route::get('job_posting/{id}/delete', [
        'uses' => 'AgencyController@deleteJobPosting',
        'as' => 'delete.job.posting'
    ]);

});

Route::group(['prefix' => 'account/agency', 'namespace' => 'Agencies'], function () {

    Route::get('profile', [
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
        'uses' => 'AccountController@accountSettings',
        'as' => 'agency.settings'
    ]);

    Route::put('settings/update', [
        'uses' => 'AccountController@updateAccount',
        'as' => 'agency.update.settings'
    ]);

    Route::group(['prefix' => 'vacancy'], function () {

        Route::get('status', [
            'uses' => 'AccountController@showVacancyStatus',
            'as' => 'agency.vacancy.status'
        ]);

        Route::get('/', [
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

        Route::get('application_review', [
            'uses' => 'AccountController@showDashboard',
            'as' => 'agency.dashboard'
        ]);

        Route::get('invited_seeker', [
            'uses' => 'AccountController@invitedSeeker',
            'as' => 'agency.invited.seeker'
        ]);

    });

});
