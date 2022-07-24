<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function () {
    Route::get('/failPayment', function () { return view('website.fail');})->name('failPayment');
    Route::get('/successPayment', function () { return view('website.success');})->name('successPayment');
    Route::get('/payment', function () { return view('website.payment');})->name('payment');


    Route::group(['middleware' => ['auth']], function () {
        Route::get('profile', 'WEB\Site\UsersController@myProfile')->name('profile');
        Route::get('edit-profile', 'WEB\Site\UsersController@editMyProfile')->name('editMyProfile');
        Route::post('update-profile', 'WEB\Site\UsersController@updateMyProfile')->name('updateMyProfile');
        Route::get('favorite', 'WEB\Site\UsersController@favorite')->name('favorite');
        Route::get('logout', 'WEB\Site\UsersController@logout')->name('logout');

    });



    Route::get('/', 'WEB\Site\HomeController@home')->name('home');
    Route::get('departments/{id}/{slug}', 'WEB\Site\HomeController@departments')->name('departments');
    Route::get('courses/{id}/{year_id}/{slug}', 'WEB\Site\HomeController@courses')->name('courses');
    Route::get('requirements', 'WEB\Site\HomeController@requirements')->name('requirements');
    Route::get('requirement-videos/{main_video}/{id}/{slug}', 'WEB\Site\HomeController@requirementVideos')->name('requirementVideos');
    Route::get('requirement-files/{id}/{slug}', 'WEB\Site\HomeController@requirementFiles')->name('requirementFiles');

    Route::get('videos/{id}/{main_video}/{slug}', 'WEB\Site\HomeController@videos')->name('videos');
    Route::get('files/{id}/{slug}', 'WEB\Site\HomeController@files')->name('files');
    Route::get('/add-favorite/{id}','WEB\Site\HomeController@addFavorite');
    Route::get('/remove-favorite/{id}','WEB\Site\HomeController@removeFavorite');
    Route::post('/comment/{id}','WEB\Site\HomeController@comment')->name('comment');
    Route::get('about', 'WEB\Site\HomeController@about')->name('about');



    Route::get('/pages/{slug}', 'WEB\Site\HomeController@pages')->name('pages');



    Route::get('/login', 'WEB\Site\UsersController@loginView')->name('login');

    Route::post('/login', 'WEB\Site\UsersController@loginPost')->name('loginPost');
    Route::post('/register', 'WEB\Site\UsersController@registerPost')->name('registerPost');

    Route::get('/contact', 'WEB\Site\HomeController@contact')->name('contact');
    Route::post('/contact_us', 'WEB\Site\HomeController@contactUs');
    Route::get('/page/{id}', 'WEB\Site\HomeController@pages');

    Route::get('forgot/password', 'Auth\ForgotPasswordController@forgotPasswordForm')->name('forgotPasswordForm');
    Route::post('sendResetLinkEmail', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('sendResetLinkEmail');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.new');
     Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');


    //ADMIN AUTH ///

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', function () {
            return route('/login');
        });


        Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login.form');
        Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.login');
        Route::get('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
      //  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
     //   Route::post('/password/email', 'AdminAuth\ForgotPasswordController@send_email')->name('admin.password.email');
    });





    Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin', 'as' => 'admin.',], function () {
        Route::get('/', function () {
            return redirect('/admin/home');
        });
        Route::post('/changeStatus/{model}', 'WEB\Admin\HomeController@changeStatus');

        Route::get('home', 'WEB\Admin\HomeController@index')->name('admin.home');

        Route::get('/admins/{id}/edit', 'WEB\Admin\AdminController@edit')->name('admins.edit');
        Route::patch('/admins/{id}', 'WEB\Admin\AdminController@update')->name('users.update');
        Route::get('/admins/{id}/edit_password', 'WEB\Admin\AdminController@edit_password')->name('admins.edit_password');
        Route::post('/admins/{id}/edit_password', 'WEB\Admin\AdminController@update_password')->name('admins.edit_password');

        if (can('admins')) {
            Route::get('/admins', 'WEB\Admin\AdminController@index')->name('admins.all');
            Route::post('/admins/changeStatus', 'WEB\Admin\AdminController@changeStatus')->name('admin_changeStatus');

            Route::delete('admins/{id}', 'WEB\Admin\AdminController@destroy')->name('admins.destroy');

            Route::post('/admins', 'WEB\Admin\AdminController@store')->name('admins.store');
            Route::get('/admins/create', 'WEB\Admin\AdminController@create')->name('admins.create');
            Route::get('/editMyProfile', 'WEB\Admin\AdminController@editMyProfile')->name('admins.editMyProfile');
            Route::post('/updateProfile', 'WEB\Admin\AdminController@updateProfile')->name('admins.updateProfile');
            Route::get('/changeMyPassword', 'WEB\Admin\AdminController@changeMyPassword')->name('admins.changeMyPassword');
            Route::post('/updateMyPassword', 'WEB\Admin\AdminController@updateMyPassword')->name('admins.updateMyPassword');
        }

        if (can('users')) {


            Route::get('/users', 'WEB\Admin\UsersController@index')->name('users.all');
            Route::post('/users', 'WEB\Admin\UsersController@store')->name('users.store');
            Route::get('/users/create', 'WEB\Admin\UsersController@create')->name('users.create');
            Route::delete('users/{id}', 'WEB\Admin\UsersController@destroy')->name('users.destroy');
            Route::get('/users/{id}/edit', 'WEB\Admin\UsersController@edit')->name('users.edit');
            Route::get('/users/{id}/show', 'WEB\Admin\UsersController@show')->name('users.show');

            Route::patch('/users/{id}', 'WEB\Admin\UsersController@update')->name('users.update');
            Route::get('/users/{id}/edit_password', 'WEB\Admin\UsersController@edit_password')->name('users.edit_password');
            Route::post('/users/{id}/edit_password', 'WEB\Admin\UsersController@update_password')->name('users.edit_password');
            Route::get('/exportUsers', 'WEB\Admin\UsersController@exportUsers');

        }


        Route::get('/getDepartments','WEB\Admin\FacultiesController@getDepartments');
        Route::resource('/faculties', 'WEB\Admin\FacultiesController');

        Route::get('/getCourses','WEB\Admin\DepartmentController@getCourses');
        Route::get('/getYears','WEB\Admin\DepartmentController@getYears');
        Route::resource('/departments', 'WEB\Admin\DepartmentController');

        Route::resource('/courses', 'WEB\Admin\CourseController');

        Route::resource('/requirements', 'WEB\Admin\RequirementController');
        Route::resource('/requirementsVideos', 'WEB\Admin\RequirementsVideosController');
        Route::resource('/requirementsFiles', 'WEB\Admin\RequirementsFilesController');

        Route::resource('/videos', 'WEB\Admin\VideoController');
        Route::resource('/files', 'WEB\Admin\FileController');
        Route::resource('/partners', 'WEB\Admin\PartnersController');
        Route::resource('/roles', 'WEB\Admin\RolesController');



    });
});


