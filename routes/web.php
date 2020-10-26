<?php

use Illuminate\Support\Facades\Route;

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
Route::middleware(['under-construction'])->group(function(){
    Auth::routes(['verify' => true]);
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/post-detail/{id}', 'HomeController@post_detail')->name('post-detail');
    Route::get('/post/{id}/reviews', 'PostController@post_reviews');
    Route::middleware(['auth'])->group(function (){
        Route::get('/home', 'ProfileController@index')->name('home');
        Route::post('/profile', 'ProfileController@update_profile')->name('update.profile');
        Route::post('/profile/gender', 'ProfileController@update_gender')->name('update.gender');
        Route::post('/profile/password', 'ProfileController@update_password')->name('update.profile.password');
        Route::post('/profile/photo', 'ProfileController@profile_photo')->name('update.profile.photo');
        Route::get('/provide-service', 'HomeController@provide_service')->name('provide-service');
        Route::get('/edit-service', 'HomeController@edit_service');
        Route::post('/posts', 'PostController@store');
        Route::put('/posts/{id}', 'PostController@update');
        Route::post('/post-detail/contact', 'ContactController@post_detail_contact');
        Route::post('/reviews', 'ReviewController@store');
    });
    /* admin prefixed routes */
    Route::prefix('admin')->middleware(['role:admin'])->group(function(){
        Route::get('/', 'HomeController@dashboard')->name('dashboard');
        /* category */
        Route::post('/category/restore/{id}', 'CategoryController@restore')->name('category.restore');
        Route::resource('/category', 'CategoryController');
        /* countries */
        Route::post('/countries/restore/{id}', 'CountryController@restore')->name('countries.restore');
        Route::resource('/countries', 'CountryController');
        /* states */
        Route::post('/states/restore/{id}', 'StateController@restore')->name('states.restore');
        Route::resource('/states', 'StateController');
        /* cities */
        Route::post('/cities/restore/{id}', 'CityController@restore')->name('cities.restore');
        Route::resource('/cities', 'CityController');
        /* zipcode */
        Route::post('/zipcodes/restore/{id}', 'ZipcodeController@restore')->name('zipcodes.restore');
        Route::resource('/zipcodes', 'ZipcodeController');
        /* languages */
        Route::post('/languages/restore/{id}', 'LanguageController@restore')->name('languages.restore');
        Route::resource('/languages', 'LanguageController');
        /* referrer */
        Route::post('/referrers/restore/{id}', 'ReferrerController@restore')->name('referrers.restore');
        Route::resource('/referrers', 'ReferrerController');
        /* services */
        Route::post('/services/restore/{id}', 'ServiceController@restore')->name('services.restore');
        Route::resource('/services', 'ServiceController');
        /* users */
        Route::post('/users/restore/{id}', 'UserController@restore')->name('users.restore');
        Route::post('/users/{id}/profile-photo', 'UserController@confirm_profile_photo')
            ->name('users.profile-photo');
        Route::post('/users/{id}/profile-photo/delete', 'UserController@delete_profile_photo')
            ->name('users.delete.profile-photo');
        Route::post('/users/{id}/profile-photo/update', 'UserController@update_profile_photo')
            ->name('users.update.profile-photo');
        Route::put('/users/{id}/password', 'UserController@update_password')
            ->name('users.update.password');
        Route::resource('/users', 'UserController');
        /* posts */
        Route::post('/posts/restore/{id}', 'PostController@restore')->name('posts.restore');
        Route::post('/posts/verify/{id}', 'PostController@verify')->name('posts.verify');
        Route::post('/posts/re-verify/{id}', 'PostController@re_verify')->name('posts.re-verify');
        Route::post('/posts/unverify/{id}', 'PostController@unverify')->name('posts.unverify');
        Route::put('/posts/{id}/featured', 'PostController@set_featured');
        Route::resource('/posts', 'PostController');
        
        /* search */
        
        Route::get('/setting/search', 'AdminSettingController@search')->name('setting.search');
        Route::post('/setting/search/default_city', 'AdminSettingController@store_city')->name('setting.search.default_city.store');
    });
    /* end of admin prefixed routes */
});
