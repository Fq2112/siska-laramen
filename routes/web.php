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

Route::group(['namespace' => 'Admins', 'prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/', [
        'uses' => 'AdminController@index',
        'as' => 'home-admin'
    ]);

    Route::get('inbox', [
        'uses' => 'AdminController@showInbox',
        'as' => 'admin.inbox'
    ]);

    Route::group(['prefix' => 'tables'], function () {

        Route::group(['namespace' => 'DataMaster'], function () {

            Route::group(['prefix' => 'accounts'], function () {

                Route::get('/', [
                    'uses' => 'UsersController@showUsersTable',
                    'as' => 'table.users'
                ]);

                Route::get('{id}/detail', [
                    'uses' => 'UsersController@detailUsers',
                    'as' => 'detail.users'
                ]);

                Route::get('{id}/delete', [
                    'uses' => 'UsersController@deleteUsers',
                    'as' => 'delete.users'
                ]);

                Route::group(['prefix' => 'agencies'], function () {

                    Route::get('/', [
                        'uses' => 'UsersController@showAgenciesTable',
                        'as' => 'table.agencies'
                    ]);

                    Route::get('{id}/detail', [
                        'uses' => 'UsersController@detailAgencies',
                        'as' => 'detail.agencies'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'UsersController@deleteAgencies',
                        'as' => 'delete.agencies'
                    ]);

                });

                Route::group(['prefix' => 'seekers'], function () {

                    Route::get('/', [
                        'uses' => 'UsersController@showSeekersTable',
                        'as' => 'table.seekers'
                    ]);

                    Route::get('{id}/detail', [
                        'uses' => 'UsersController@detailSeekers',
                        'as' => 'detail.seekers'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'UsersController@deleteSeekers',
                        'as' => 'delete.seekers'
                    ]);

                });

                Route::group(['prefix' => 'admins'], function () {

                    Route::get('/', [
                        'uses' => 'UsersController@showAdminsTable',
                        'as' => 'table.admins'
                    ]);

                    Route::get('{id}/detail', [
                        'uses' => 'UsersController@detailAdmins',
                        'as' => 'detail.admins'
                    ]);

                    Route::post('create', [
                        'uses' => 'UsersController@createAdmins',
                        'as' => 'create.admins'
                    ]);

                    Route::put('{id}/update', [
                        'uses' => 'UsersController@updateAdmins',
                        'as' => 'update.admins'
                    ]);

                    Route::get('{id}/delete', [
                        'uses' => 'UsersController@deleteAdmins',
                        'as' => 'delete.admins'
                    ]);

                });

            });

            Route::group(['prefix' => 'requirements'], function () {

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

            Route::group(['prefix' => 'web_contents'], function () {

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

            Route::group(['prefix' => 'agencies'], function () {

                Route::group(['prefix' => 'job_postings'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionAgencyController@showJobPostingsTable',
                        'as' => 'table.jobPostings'
                    ]);

                });

                Route::group(['prefix' => 'job_invitations'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionAgencyController@showJobInvitationsTable',
                        'as' => 'table.jobInvitations'
                    ]);

                });

            });

            Route::group(['prefix' => 'seekers'], function () {

                Route::group(['prefix' => 'applications'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionSeekerController@showApplicationsTable',
                        'as' => 'table.applications'
                    ]);

                });

                Route::group(['prefix' => 'fav_agencies'], function () {

                    Route::get('/', [
                        'uses' => 'TransactionSeekerController@showFavAgenciesTable',
                        'as' => 'table.favAgencies'
                    ]);

                });

            });

        });

    });

});