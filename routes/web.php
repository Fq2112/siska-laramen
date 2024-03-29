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

Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
Route::post('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');

Auth::routes();

Route::group(['prefix' => '/'], function () {

    Route::get('info', [
        'middleware' => 'visitor',
        'uses' => 'UserController@infoSISKA',
        'as' => 'info.siska'
    ]);

    Route::post('/', [
        'uses' => 'UserController@postContact',
        'as' => 'contact.submit'
    ]);

    Route::post('partnership/join', [
        'uses' => 'UserController@joinPartnership',
        'as' => 'join.partnership'
    ]);

    Route::get('interviewer', [
        'uses' => 'UserController@dashboardInterviewer',
        'as' => 'dashboard.interviewer'
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

Route::group(['namespace' => 'Admins', 'prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/', [
        'uses' => 'AdminController@index',
        'as' => 'home-admin'
    ]);

    Route::put('profile/update', [
        'uses' => 'AdminController@updateProfile',
        'as' => 'admin.update.profile'
    ]);

    Route::put('account/update', [
        'uses' => 'AdminController@updateAccount',
        'as' => 'admin.update.account'
    ]);

    Route::group(['prefix' => 'mail'], function () {

        Route::get('read/{id}/{type}', [
            'uses' => 'AdminController@getRead',
            'as' => 'admin.get.read'
        ]);

        Route::post('compose', [
            'uses' => 'AdminController@composeInbox',
            'as' => 'admin.compose.inbox'
        ]);

        Route::group(['prefix' => 'inbox'], function () {

            Route::get('/', [
                'uses' => 'AdminController@showInbox',
                'as' => 'admin.inbox'
            ]);

            Route::get('{id}/delete', [
                'uses' => 'AdminController@deleteInbox',
                'as' => 'admin.delete.inbox'
            ]);

        });

        Route::group(['prefix' => 'sent'], function () {

            Route::get('/', [
                'uses' => 'AdminController@showSent',
                'as' => 'admin.sent'
            ]);

            Route::get('{id}/delete', [
                'uses' => 'AdminController@deleteSent',
                'as' => 'admin.delete.sent'
            ]);

        });

    });

    Route::group(['prefix' => 'quiz'], function () {

        Route::get('/', [
            'uses' => 'AdminController@showQuizInfo',
            'as' => 'quiz.info'
        ]);

        Route::get('vacancy/{id}', [
            'uses' => 'AdminController@getQuizVacancyInfo',
            'as' => 'quiz.vacancy.info'
        ]);

        Route::post('create', [
            'uses' => 'AdminController@createQuizInfo',
            'as' => 'quiz.create.info'
        ]);

        Route::put('{id}/update', [
            'uses' => 'AdminController@updateQuizInfo',
            'as' => 'quiz.update.info'
        ]);

        Route::get('{id}/delete', [
            'uses' => 'AdminController@deleteQuizInfo',
            'as' => 'quiz.delete.info'
        ]);

    });

    Route::group(['prefix' => 'psychoTest'], function () {

        Route::get('/', [
            'uses' => 'AdminController@showPsychoTestInfo',
            'as' => 'psychoTest.info'
        ]);

        Route::get('vacancy/{id}', [
            'uses' => 'AdminController@getPsychoTestVacancyInfo',
            'as' => 'psychoTest.vacancy.info'
        ]);

        Route::post('room/create', [
            'uses' => 'AdminController@createPsychoTestInfo',
            'as' => 'psychoTest.create.info'
        ]);

        Route::put('{id}/update', [
            'uses' => 'AdminController@updatePsychoTestInfo',
            'as' => 'psychoTest.update.info'
        ]);

        Route::get('{id}/delete', [
            'uses' => 'AdminController@deletePsychoTestInfo',
            'as' => 'psychoTest.delete.info'
        ]);

    });

    Route::group(['prefix' => 'tables'], function () {

        Route::group(['namespace' => 'DataMaster'], function () {

            Route::group(['prefix' => 'accounts', 'middleware' => 'root'], function () {

                Route::group(['prefix' => 'admins'], function () {

                    Route::get('/', [
                        'uses' => 'AccountsController@showAdminsTable',
                        'as' => 'table.admins'
                    ]);

                    Route::post('create', [
                        'uses' => 'AccountsController@createAdmins',
                        'as' => 'create.admins'
                    ]);

                    Route::put('{id}/update/profile', [
                        'uses' => 'AccountsController@updateProfileAdmins',
                        'as' => 'update.profile.admins'
                    ]);

                    Route::put('{id}/update/account', [
                        'uses' => 'AccountsController@updateAccountAdmins',
                        'as' => 'update.account.admins'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'AccountsController@deleteAdmins',
                        'as' => 'delete.admins'
                    ]);

                });

                Route::group(['prefix' => 'users'], function () {

                    Route::get('/', [
                        'uses' => 'AccountsController@showUsersTable',
                        'as' => 'table.users'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'AccountsController@deleteUsers',
                        'as' => 'delete.users'
                    ]);

                });

                Route::group(['prefix' => 'agencies'], function () {

                    Route::get('/', [
                        'uses' => 'AccountsController@showAgenciesTable',
                        'as' => 'table.agencies'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'AccountsController@deleteAgencies',
                        'as' => 'delete.agencies'
                    ]);

                });

                Route::group(['prefix' => 'seekers'], function () {

                    Route::get('/', [
                        'uses' => 'AccountsController@showSeekersTable',
                        'as' => 'table.seekers'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'AccountsController@deleteSeekers',
                        'as' => 'delete.seekers'
                    ]);

                });

            });

            Route::group(['prefix' => 'bank_soal', 'middleware' => 'quiz_staff'], function () {

                Route::group(['prefix' => 'topics'], function () {

                    Route::get('/', [
                        'uses' => 'BankSoalController@showQuizTopics',
                        'as' => 'quiz.topics'
                    ]);

                    Route::post('create', [
                        'uses' => 'BankSoalController@createQuizTopics',
                        'as' => 'quiz.create.topics'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'BankSoalController@updateQuizTopics',
                        'as' => 'quiz.update.topics'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'BankSoalController@deleteQuizTopics',
                        'as' => 'quiz.delete.topics'
                    ]);

                });

                Route::group(['prefix' => 'questions'], function () {

                    Route::get('/', [
                        'uses' => 'BankSoalController@showQuizQuestions',
                        'as' => 'quiz.questions'
                    ]);

                    Route::post('create', [
                        'uses' => 'BankSoalController@createQuizQuestions',
                        'as' => 'quiz.create.questions'
                    ]);

                    Route::get('{id}/edit', [
                        'uses' => 'BankSoalController@editQuizQuestions',
                        'as' => 'quiz.edit.questions'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'BankSoalController@updateQuizQuestions',
                        'as' => 'quiz.update.questions'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'BankSoalController@deleteQuizQuestions',
                        'as' => 'quiz.delete.questions'
                    ]);

                });

                Route::group(['prefix' => 'options'], function () {

                    Route::get('/', [
                        'uses' => 'BankSoalController@showQuizOptions',
                        'as' => 'quiz.options'
                    ]);

                    Route::post('create', [
                        'uses' => 'BankSoalController@createQuizOptions',
                        'as' => 'quiz.create.options'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'BankSoalController@updateQuizOptions',
                        'as' => 'quiz.update.options'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'BankSoalController@deleteQuizOptions',
                        'as' => 'quiz.delete.options'
                    ]);

                });

            });

            Route::group(['prefix' => 'requirements', 'middleware' => 'root'], function () {

                Route::group(['prefix' => 'degrees'], function () {

                    Route::get('/', [
                        'uses' => 'RequirementsController@showDegreesTable',
                        'as' => 'table.degrees'
                    ]);

                    Route::post('create', [
                        'uses' => 'RequirementsController@createDegrees',
                        'as' => 'create.degrees'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'RequirementsController@updateDegrees',
                        'as' => 'update.degrees'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'RequirementsController@deleteDegrees',
                        'as' => 'delete.degrees'
                    ]);

                });

                Route::group(['prefix' => 'majors'], function () {

                    Route::get('/', [
                        'uses' => 'RequirementsController@showMajorsTable',
                        'as' => 'table.majors'
                    ]);

                    Route::post('create', [
                        'uses' => 'RequirementsController@createMajors',
                        'as' => 'create.majors'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'RequirementsController@updateMajors',
                        'as' => 'update.majors'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'RequirementsController@deleteMajors',
                        'as' => 'delete.majors'
                    ]);

                });

                Route::group(['prefix' => 'industries'], function () {

                    Route::get('/', [
                        'uses' => 'RequirementsController@showIndustriesTable',
                        'as' => 'table.industries'
                    ]);

                    Route::post('create', [
                        'uses' => 'RequirementsController@createIndustries',
                        'as' => 'create.industries'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'RequirementsController@updateIndustries',
                        'as' => 'update.industries'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'RequirementsController@deleteIndustries',
                        'as' => 'delete.industries'
                    ]);

                });

                Route::group(['prefix' => 'job_functions'], function () {

                    Route::get('/', [
                        'uses' => 'RequirementsController@showJobFunctionsTable',
                        'as' => 'table.JobFunctions'
                    ]);

                    Route::post('create', [
                        'uses' => 'RequirementsController@createJobFunctions',
                        'as' => 'create.JobFunctions'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'RequirementsController@updateJobFunctions',
                        'as' => 'update.JobFunctions'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'RequirementsController@deleteJobFunctions',
                        'as' => 'delete.JobFunctions'
                    ]);

                });

                Route::group(['prefix' => 'job_levels'], function () {

                    Route::get('/', [
                        'uses' => 'RequirementsController@showJobLevelsTable',
                        'as' => 'table.JobLevels'
                    ]);

                    Route::post('create', [
                        'uses' => 'RequirementsController@createJobLevels',
                        'as' => 'create.JobLevels'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'RequirementsController@updateJobLevels',
                        'as' => 'update.JobLevels'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'RequirementsController@deleteJobLevels',
                        'as' => 'delete.JobLevels'
                    ]);

                });

                Route::group(['prefix' => 'job_types'], function () {

                    Route::get('/', [
                        'uses' => 'RequirementsController@showJobTypesTable',
                        'as' => 'table.JobTypes'
                    ]);

                    Route::post('create', [
                        'uses' => 'RequirementsController@createJobTypes',
                        'as' => 'create.JobTypes'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'RequirementsController@updateJobTypes',
                        'as' => 'update.JobTypes'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'RequirementsController@deleteJobTypes',
                        'as' => 'delete.JobTypes'
                    ]);

                });

                Route::group(['prefix' => 'salaries'], function () {

                    Route::get('/', [
                        'uses' => 'RequirementsController@showSalariesTable',
                        'as' => 'table.salaries'
                    ]);

                    Route::post('create', [
                        'uses' => 'RequirementsController@createSalaries',
                        'as' => 'create.salaries'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'RequirementsController@updateSalaries',
                        'as' => 'update.salaries'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'RequirementsController@deleteSalaries',
                        'as' => 'delete.salaries'
                    ]);

                });

            });

            Route::group(['prefix' => 'web_contents', 'middleware' => 'root'], function () {

                Route::group(['prefix' => 'carousels'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showCarouselsTable',
                        'as' => 'table.carousels'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createCarousels',
                        'as' => 'create.carousels'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateCarousels',
                        'as' => 'update.carousels'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteCarousels',
                        'as' => 'delete.carousels'
                    ]);

                });

                Route::group(['prefix' => 'payment_categories'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showPaymentCategoriesTable',
                        'as' => 'table.PaymentCategories'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createPaymentCategories',
                        'as' => 'create.PaymentCategories'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updatePaymentCategories',
                        'as' => 'update.PaymentCategories'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deletePaymentCategories',
                        'as' => 'delete.PaymentCategories'
                    ]);

                });

                Route::group(['prefix' => 'payment_methods'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showPaymentMethodsTable',
                        'as' => 'table.PaymentMethods'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createPaymentMethods',
                        'as' => 'create.PaymentMethods'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updatePaymentMethods',
                        'as' => 'update.PaymentMethods'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deletePaymentMethods',
                        'as' => 'delete.PaymentMethods'
                    ]);

                });

                Route::group(['prefix' => 'plans'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showPlansTable',
                        'as' => 'table.plans'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createPlans',
                        'as' => 'create.plans'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updatePlans',
                        'as' => 'update.plans'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deletePlans',
                        'as' => 'delete.plans'
                    ]);

                });

                Route::group(['prefix' => 'nations'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showNationsTable',
                        'as' => 'table.nations'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createNations',
                        'as' => 'create.nations'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateNations',
                        'as' => 'update.nations'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteNations',
                        'as' => 'delete.nations'
                    ]);

                });

                Route::group(['prefix' => 'provinces'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showProvincesTable',
                        'as' => 'table.provinces'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createProvinces',
                        'as' => 'create.provinces'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateProvinces',
                        'as' => 'update.provinces'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteProvinces',
                        'as' => 'delete.provinces'
                    ]);

                });

                Route::group(['prefix' => 'cities'], function () {

                    Route::get('/', [
                        'uses' => 'WebContentsController@showCitiesTable',
                        'as' => 'table.cities'
                    ]);

                    Route::post('create', [
                        'uses' => 'WebContentsController@createCities',
                        'as' => 'create.cities'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'WebContentsController@updateCities',
                        'as' => 'update.cities'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'WebContentsController@deleteCities',
                        'as' => 'delete.cities'
                    ]);

                });

                Route::group(['prefix' => 'blog'], function () {

                    Route::get('/', [
                        'uses' => 'BlogController@showBlogTable',
                        'as' => 'table.blog'
                    ]);

                    Route::post('create', [
                        'uses' => 'BlogController@createBlog',
                        'as' => 'create.blog'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'BlogController@updateBlog',
                        'as' => 'update.blog'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'BlogController@deleteBlog',
                        'as' => 'delete.blog'
                    ]);

                    Route::get('types', [
                        'uses' => 'BlogController@showBlogTypesTable',
                        'as' => 'table.blogTypes'
                    ]);

                    Route::post('types/create', [
                        'uses' => 'BlogController@createBlogTypes',
                        'as' => 'create.blogTypes'
                    ]);

                    Route::put('types/{id}/update', [
                        'uses' => 'BlogController@updateBlogTypes',
                        'as' => 'update.blogTypes'
                    ]);

                    Route::get('types/{id}/delete', [
                        'uses' => 'BlogController@deleteBlogTypes',
                        'as' => 'delete.blogTypes'
                    ]);

                });

            });

        });

        Route::group(['namespace' => 'DataTransaction'], function () {

            Route::group(['prefix' => 'agencies', 'middleware' => 'vacancy_staff'], function () {

                Route::group(['prefix' => 'vacancies'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionAgencyController@showVacanciesTable',
                        'as' => 'table.vacancies'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionAgencyController@deleteVacancies',
                        'as' => 'delete.vacancies'
                    ]);

                });

                Route::group(['prefix' => 'job_postings'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionAgencyController@showJobPostingsTable',
                        'as' => 'table.jobPostings'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'TransactionAgencyController@updateJobPostings',
                        'as' => 'table.jobPostings.update'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'TransactionAgencyController@deleteJobPostings',
                        'as' => 'table.jobPostings.delete'
                    ]);

                });

            });

            Route::group(['prefix' => 'seekers', 'middleware' => 'vacancy_staff'], function () {

                Route::group(['prefix' => 'applied_invitations'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionSeekerController@showAppliedInvitationsTable',
                        'as' => 'table.appliedInvitations'
                    ]);

                    Route::post('send', [
                        'uses' => 'TransactionSeekerController@massSendAppliedInvitations',
                        'as' => 'table.appliedInvitations.massSend'
                    ]);

                    Route::post('delete', [
                        'uses' => 'TransactionSeekerController@massDeleteAppliedInvitations',
                        'as' => 'table.appliedInvitations.massDelete'
                    ]);

                });

                Route::group(['prefix' => 'applications'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionSeekerController@showApplicationsTable',
                        'as' => 'table.applications'
                    ]);

                    Route::post('send', [
                        'uses' => 'TransactionSeekerController@massSendApplications',
                        'as' => 'table.applications.massSend'
                    ]);

                    Route::post('delete', [
                        'uses' => 'TransactionSeekerController@massDeleteApplications',
                        'as' => 'table.applications.massDelete'
                    ]);

                });

                Route::group(['prefix' => 'quiz_results'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionSeekerController@showQuizResultsTable',
                        'as' => 'table.quizResults'
                    ]);

                    Route::post('send', [
                        'uses' => 'TransactionSeekerController@massSendQuizResults',
                        'as' => 'table.quizResults.massSend'
                    ]);

                    Route::post('delete', [
                        'uses' => 'TransactionSeekerController@massDeleteQuizResults',
                        'as' => 'table.quizResults.massDelete'
                    ]);

                });

                Route::group(['prefix' => 'psychoTest_results'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionSeekerController@showPsychoTestResultsTable',
                        'as' => 'table.psychoTestResults'
                    ]);

                    Route::post('send', [
                        'uses' => 'TransactionSeekerController@massSendPsychoTestResults',
                        'as' => 'table.psychoTestResults.massSend'
                    ]);

                    Route::post('delete', [
                        'uses' => 'TransactionSeekerController@massDeletePsychoTestResults',
                        'as' => 'table.psychoTestResults.massDelete'
                    ]);

                });

            });

            Route::group(['prefix' => 'partners', 'middleware' => 'sync_staff'], function () {

                Route::get('/', [
                    'uses' => 'TransactionPartnerController@showPartnersCredentials',
                    'as' => 'partners.credentials.show'
                ]);

                Route::put('{id}/update', [
                    'uses' => 'TransactionPartnerController@updatePartnersCredentials',
                    'as' => 'partners.credentials.update'
                ]);

                Route::get('{id}/delete', [
                    'uses' => 'TransactionPartnerController@deletePartnersCredentials',
                    'as' => 'partners.credentials.delete'
                ]);

                Route::group(['prefix' => 'vacancies'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionPartnerController@showPartnersVacancies',
                        'as' => 'partners.vacancies.show'
                    ]);

                    Route::get('edit/{id}', [
                        'uses' => 'TransactionPartnerController@editPartnersVacancies',
                        'as' => 'partners.vacancies.edit'
                    ]);

                    Route::put('update/{id}', [
                        'uses' => 'TransactionPartnerController@updatePartnersVacancies',
                        'as' => 'partners.vacancies.update'
                    ]);

                    Route::post('posts', [
                        'uses' => 'TransactionPartnerController@massPostPartnersVacancies',
                        'as' => 'partners.vacancies.massPost'
                    ]);

                    Route::post('pdf', [
                        'uses' => 'TransactionPartnerController@massGeneratePDF',
                        'as' => 'partners.vacancies.massPDF'
                    ]);

                    Route::post('delete', [
                        'uses' => 'TransactionPartnerController@massDeletePartnersVacancies',
                        'as' => 'partners.vacancies.massDelete'
                    ]);

                });

            });

        });

    });

});
