<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', ['as'=>'home', 'uses'=>'HomeController@welcome']);

Route::resource('worker', 'WorkerController');

Route::get('register', ['as'=>'register.create', 'uses'=>'RegistrationController@create']);
Route::post('register',['as'=>'register.store', 'uses'=>'RegistrationController@store']);

Route::get('login', ['as'=>'login.create', 'uses'=>'LoginController@create']);
Route::post('login',['as'=>'login.store', 'uses'=>'LoginController@store']);

Route::get('logout', 'LogoutController@getLogout');

Route::get('fp', ['as'=>'fp.create', 'uses'=>'ForgottenPasswordController@create']);
Route::post('fp',['as'=>'fp.store', 'uses'=>'ForgottenPasswordController@store']);

Route::get('reset/{email}/{identifier}', ['as'=>'reset.create', 'uses'=>'ResetPasswordController@create']);
Route::post('reset',['as'=>'reset.store', 'uses'=>'ResetPasswordController@store']);

Route::resource('site', 'ConstructionSiteController');

Route::get('search', ['as'=>'search', 'uses'=>'AutocompleteController@autocompleteAction']);
Route::post('month_meal',['as'=>'month_meal.store', 'uses'=>'AutocompleteController@storeMonthMeal']);
Route::get('month_meal',['as'=>'month_meal.get', 'uses'=>'AutocompleteController@storeMonthMeal']);
Route::get('coupon_search',['as'=>'coupon', 'uses'=>'AutocompleteController@autocompleteCouponAction']);
Route::get('edit_coupon_search',['as'=>'edit_coupon', 'uses'=>'AutocompleteController@autocompleteEditCouponAction']);
Route::post('post_credentials_month_meal',['as'=>'check', 'uses'=>'AutocompleteController@distributionDuplicate']);
Route::get('post_credentials_month_meal',['as'=>'check', 'uses'=>'AutocompleteController@distributionDuplicate']);
Route::post('post_title',['as'=>'p_check', 'uses'=>'AutocompleteController@processingDuplicate']);
Route::get('post_title',['as'=>'p_check', 'uses'=>'AutocompleteController@processingDuplicate']);
Route::get('name_search',['as'=>'name', 'uses'=>'AutocompleteController@autocompleteNameAction']);
Route::post('name_search',['as'=>'name', 'uses'=>'AutocompleteController@autocompleteNameAction']);

Route::resource('distribute', 'CouponDistributionController', ['except'=>['edit','show','update']]);
Route::get('dlist/{title}', ['as'=>'dlist', 'uses'=>'CouponDistributionController@showDlist']);
Route::post('distribute_verify',['as'=>'dlist.verify', 'uses'=>'CouponDistributionController@verifyDlist']);
Route::get('distribute_terminate',['as'=>'dlist.terminate', 'uses'=>'CouponDistributionController@terminate']);

Route::get('process', ['as'=>'process.index', 'uses'=>'ProcessingController@index']);
Route::get('process/create', ['as'=>'process.create', 'uses'=>'ProcessingController@create']);
Route::get('process/create_breakfast_dinner', ['as'=>'process.createbd', 'uses'=>'ProcessingController@createBD']);
Route::post('processBD',['as'=>'process.storeBD', 'uses'=>'ProcessingController@storeBD']);
Route::post('process',['as'=>'process.store', 'uses'=>'ProcessingController@store']);
Route::get('process/{title}', ['as'=>'plist', 'uses'=>'ProcessingController@showPlist']);
Route::post('process_plist',['as'=>'plist.store', 'uses'=>'ProcessingController@storePlist']);
Route::post('process/edit', ['as'=>'plist.edit', 'uses'=>'ProcessingController@edit']);
Route::post('process/update', ['as'=>'plist.update', 'uses'=>'ProcessingController@update']);

Route::get('get_distribution_data',['as'=>'present.distribution', 'uses'=>'SearchController@presentDistributionForm']);
Route::post('get_distribution_data',['as'=>'present.distribution', 'uses'=>'SearchController@presentDistributionForm']);
Route::get('get_processing_data',['as'=>'present.processing', 'uses'=>'SearchController@presentProcessingForm']);
Route::post('get_processing_data',['as'=>'present.processing', 'uses'=>'SearchController@presentProcessingForm']);

Route::get('admin_panel',['as'=>'panel','uses'=>'AdminPanelController@index']);
Route::post('dismiss_editors',['as'=>'dismissions','uses'=>'AdminPanelController@remove']);
Route::post('add_editors',['as'=>'additions','uses'=>'AdminPanelController@add']);
});
