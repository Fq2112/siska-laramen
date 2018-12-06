<?php
/**
 * Created by PhpStorm.
 * User: ilham
 * Date: 8/1/2018
 * Time: 2:48 PM
 */

Route::get('seekers/{id}', [
    'uses' => 'Seekers\SeekerController@showProfile',
    'as' => 'seeker.profile'
]);

Route::group(['prefix' => '/', 'namespace' => 'Seekers'], function () {

    Route::get('/', [
        'uses' => 'SeekerController@index',
        'as' => 'home-seeker'
    ]);

    Route::post('agencies/favorite', [
        'uses' => 'SeekerController@favoriteAgency',
        'as' => 'favorite.agency'
    ]);

    Route::get('search', [
        'uses' => 'VacancyController@showVacancy',
        'as' => 'search.vacancy'
    ]);

    Route::group(['prefix' => 'account'], function () {

        Route::get('profile', [
            'uses' => 'AccountController@editProfile',
            'as' => 'seeker.edit.profile'
        ]);

        Route::put('profile/update', [
            'uses' => 'AccountController@updateProfile',
            'as' => 'update.profile'
        ]);

        Route::get('settings', [
            'uses' => 'AccountController@accountSettings',
            'as' => 'seeker.settings'
        ]);

        Route::put('settings/update', [
            'uses' => 'AccountController@updateAccount',
            'as' => 'update.settings'
        ]);

        Route::put('background/update', [
            'uses' => 'AccountController@updateBackground',
            'as' => 'update.background'
        ]);

        Route::post('profile/attachments/create', [
            'uses' => 'AccountController@createAttachments',
            'as' => 'create.attachments'
        ]);

        Route::get('profile/attachments/delete', [
            'uses' => 'AccountController@deleteAttachments',
            'as' => 'delete.attachments'
        ]);

        Route::post('profile/experiences/create', [
            'uses' => 'AccountController@createExperiences',
            'as' => 'create.experiences'
        ]);

        Route::get('profile/experiences/edit/{id}', [
            'uses' => 'AccountController@editExperiences',
            'as' => 'edit.experiences'
        ]);

        Route::put('profile/experiences/update/{id}', [
            'uses' => 'AccountController@updateExperiences',
            'as' => 'update.experiences'
        ]);

        Route::get('profile/experiences/delete/{id}/{exp}', [
            'uses' => 'AccountController@deleteExperiences',
            'as' => 'delete.experiences'
        ]);

        Route::post('profile/educations/create', [
            'uses' => 'AccountController@createEducations',
            'as' => 'create.educations'
        ]);

        Route::get('profile/educations/edit/{id}', [
            'uses' => 'AccountController@editEducations',
            'as' => 'edit.educations'
        ]);

        Route::put('profile/educations/update/{id}', [
            'uses' => 'AccountController@updateEducations',
            'as' => 'update.educations'
        ]);

        Route::get('profile/educations/delete/{id}/{exp}', [
            'uses' => 'AccountController@deleteEducations',
            'as' => 'delete.educations'
        ]);

        Route::post('profile/trainings/create', [
            'uses' => 'AccountController@createTrainings',
            'as' => 'create.trainings'
        ]);

        Route::get('profile/trainings/edit/{id}', [
            'uses' => 'AccountController@editTrainings',
            'as' => 'edit.trainings'
        ]);

        Route::put('profile/trainings/update/{id}', [
            'uses' => 'AccountController@updateTrainings',
            'as' => 'update.trainings'
        ]);

        Route::get('profile/trainings/delete/{id}/{exp}', [
            'uses' => 'AccountController@deleteTrainings',
            'as' => 'delete.trainings'
        ]);

        Route::post('profile/organizations/create', [
            'uses' => 'AccountController@createOrganizations',
            'as' => 'create.organizations'
        ]);

        Route::get('profile/organizations/edit/{id}', [
            'uses' => 'AccountController@editOrganizations',
            'as' => 'edit.organizations'
        ]);

        Route::put('profile/organizations/update/{id}', [
            'uses' => 'AccountController@updateOrganizations',
            'as' => 'update.organizations'
        ]);

        Route::get('profile/organizations/delete/{id}/{exp}', [
            'uses' => 'AccountController@deleteOrganizations',
            'as' => 'delete.organizations'
        ]);

        Route::post('profile/languages/create', [
            'uses' => 'AccountController@createLanguages',
            'as' => 'create.languages'
        ]);

        Route::get('profile/languages/edit/{id}', [
            'uses' => 'AccountController@editLanguages',
            'as' => 'edit.languages'
        ]);

        Route::put('profile/languages/update/{id}', [
            'uses' => 'AccountController@updateLanguages',
            'as' => 'update.languages'
        ]);

        Route::get('profile/languages/delete/{id}/{exp}', [
            'uses' => 'AccountController@deleteLanguages',
            'as' => 'delete.languages'
        ]);

        Route::post('profile/skills/create', [
            'uses' => 'AccountController@createSkills',
            'as' => 'create.skills'
        ]);

        Route::get('profile/skills/edit/{id}', [
            'uses' => 'AccountController@editSkills',
            'as' => 'edit.skills'
        ]);

        Route::put('profile/skills/update/{id}', [
            'uses' => 'AccountController@updateSkills',
            'as' => 'update.skills'
        ]);

        Route::get('profile/skills/delete/{id}/{exp}', [
            'uses' => 'AccountController@deleteSkills',
            'as' => 'delete.skills'
        ]);

        Route::group(['prefix' => 'dashboard'], function () {

            Route::get('application_status', [
                'uses' => 'SeekerController@showDashboard',
                'as' => 'seeker.dashboard'
            ]);

            Route::get('application_status/compare/{id}', [
                'uses' => 'SeekerController@showCompare',
                'as' => 'compare.application'
            ]);

            Route::get('quiz_invitation', [
                'uses' => 'SeekerController@showQuizInv',
                'as' => 'seeker.invitation.quiz'
            ]);

            Route::get('psychoTest_invitation', [
                'uses' => 'SeekerController@showPsychoTestInv',
                'as' => 'seeker.invitation.psychoTest'
            ]);

            Route::get('job_invitation', [
                'uses' => 'SeekerController@showJobInvitation',
                'as' => 'seeker.jobInvitation'
            ]);

            Route::put('job_invitation/apply', [
                'uses' => 'SeekerController@applyJobInvitation',
                'as' => 'seeker.jobInvitation.apply'
            ]);

        });

        Route::group(['prefix' => 'job_vacancy'], function () {

            Route::get('recommended_vacancy', [
                'uses' => 'SeekerController@recommendedVacancy',
                'as' => 'seeker.recommended.vacancy'
            ]);

            Route::get('recommended_vacancy/vacancies', [
                'uses' => 'SeekerController@getRecommendedVacancy',
                'as' => 'get.recommended.vacancy'
            ]);

            Route::get('recommended_vacancy/{id}', [
                'uses' => 'SeekerController@detailRecommendedVacancy',
                'as' => 'detail.recommended.vacancy'
            ]);

            Route::get('bookmarked_vacancy', [
                'uses' => 'SeekerController@showBookmark',
                'as' => 'seeker.bookmarked.vacancy'
            ]);

        });
    });

    Route::group(['prefix' => 'vacancy'], function () {

        Route::get('{id}', [
            'uses' => 'VacancyController@detailVacancy',
            'as' => 'detail.vacancy'
        ]);

        Route::post('bookmark', [
            'uses' => 'VacancyController@bookmarkVacancy',
            'as' => 'bookmark.vacancy'
        ]);

        Route::post('apply', [
            'uses' => 'VacancyController@applyVacancy',
            'as' => 'apply.vacancy'
        ]);

        Route::get('{id}/requirement', [
            'uses' => 'VacancyController@getVacancyRequirement',
            'as' => 'get.vacancy.requirement'
        ]);

    });

    Route::group(['prefix' => 'quiz'], function () {

        Route::post('/', [
            'uses' => 'QuizController@showQuiz',
            'as' => 'show.quiz'
        ]);

        Route::get('questions/{question_ids}/answer/load', [
            'uses' => 'QuizController@loadQuizAnswers',
            'as' => 'load.quiz.answers'
        ]);

        Route::post('submit', [
            'uses' => 'QuizController@submitQuiz',
            'as' => 'submit.quiz'
        ]);

    });

    Route::group(['prefix' => 'psychoTest'], function () {

        Route::post('/', [
            'uses' => 'PsychoTestController@joinPsychoTestRoom',
            'as' => 'join.psychoTest.room'
        ]);

        Route::post('submit', [
            'uses' => 'PsychoTestController@submitPsychoTest',
            'as' => 'submit.psychoTest'
        ]);

    });

});