<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// clear chache route
Route::get('/clear-cache', function() {
    $exitCode    = Artisan::call('cache:clear');
    $config      = Artisan::call('config:cache');
    $view        = Artisan::call('view:clear');
    return "Cache is cleared";
});
 
Route::group(['prefix' => 'admin', 'middleware' =>'admin_auth'], function () {
	Route::get('login', 'AdminController@login')->name('admin_login');
});

Route::match(['get', 'post'],'admin/authenticate', 'AdminController@authenticate');

Route::group(['prefix' => 'admin', 'middleware' =>'admin_guest'], function () {
	Route::redirect('/','admin/dashboard');
	Route::get('dashboard', 'AdminController@index');

	Route::get('logout', 'AdminController@logout');
	Route::get('customers', 'CustomerController@index');
	Route::get('customer/delete/{id}', 'CustomerController@delete');
	Route::match(array('GET', 'POST'),'add_customer', 'CustomerController@add');
	Route::match(array('GET', 'POST'),'edit_customer/{id}', 'CustomerController@update');
	Route::post('excel-upload', 'CustomerController@excelupload');
	Route::post('customerdelete', 'CustomerController@massDestroy');
	Route::get('cutomerExport', 'CustomerController@cutomerExport');
	Route::post('cutomerImport', 'CustomerController@cutomerImport');
	
	Route::post('stockform', 'CustomerController@stockformadd');
	Route::post('updatestockform', 'CustomerController@stockformupdate');
	Route::post('getstock', 'CustomerController@getstockform');

	Route::post('filefrom', 'CustomerController@transferformadd');
	Route::post('updatetransferform', 'CustomerController@transferformupdate');
	Route::post('getfiletransfer', 'CustomerController@gettransferform');

	Route::post('posterfrom', 'CustomerController@posterformadd');
	Route::post('updateposterfrom', 'CustomerController@posterformupdate');
	Route::post('getposterfrom', 'CustomerController@getposterform');

	Route::post('visitform', 'CustomerController@visitformadd');
	Route::post('updatevisitform', 'CustomerController@visitformupdate');
	Route::post('getvisitform', 'CustomerController@getvisitform');

	Route::post('inqueryform', 'CustomerController@inqueryformadd');
	Route::post('updateinqueryform', 'CustomerController@inqueryformupdate');
	Route::post('getinqueryform', 'CustomerController@getinqueryform');
	
	
	Route::get('users', 'UserController@index')->name('admin.users');
	Route::match(['GET','POST'],'user/store', 'UserController@store')->name('admin.user.store');
	Route::match(['GET','POST'],'user/edit/{id}', 'UserController@edit')->name('admin.user.edit');
	Route::match(['GET','POST'],'user/delete/{id}', 'UserController@delete')->name('admin.user.delete');

	Route::get('user-record/stocks', 'StockTransactionController@index');
	Route::match(array('GET', 'POST'),'user-record/add_stock', 'StockTransactionController@add');
	Route::match(array('GET', 'POST'),'user-record/edit_stock/{id}', 'StockTransactionController@update');
	Route::post('user-record/stockdelete', 'StockTransactionController@massDestroy');
	Route::post('stock-status', 'StockTransactionController@statuschange');


	Route::get('user-record/file-transfers', 'FiletransferController@index');
	Route::post('file-transfer-method', 'FiletransferController@methodchange');
	Route::post('new-company', 'FiletransferController@newcompany');
	Route::post('new-group', 'FiletransferController@newgroup');
	Route::post('new-city', 'FiletransferController@newcity');
	Route::post('new-stock', 'FiletransferController@newstock');
	Route::post('new-route', 'FiletransferController@newroute');
	Route::match(array('GET', 'POST'),'user-record/add_file_transfer', 'FiletransferController@add');
	Route::match(array('GET', 'POST'),'user-record/edit_file_transfer/{id}', 'FiletransferController@update');
	Route::post('user-record/filedelete', 'FiletransferController@massDestroy');

	Route::get('user-record/post-delivery', 'PostdeliveryController@index');
	Route::post('post-status', 'PostdeliveryController@statuschange');
	Route::match(array('GET', 'POST'),'user-record/add_post_delivery', 'PostdeliveryController@add');
	Route::match(array('GET', 'POST'),'user-record/edit_post_delivery/{id}', 'PostdeliveryController@update');
	Route::post('user-record/postdelete', 'PostdeliveryController@massDestroy');

	Route::get('user-record/visit-record', 'VisitrecordController@index');
	Route::post('visit-status', 'VisitrecordController@statuschange');
	Route::match(array('GET', 'POST'),'user-record/add_visit_record', 'VisitrecordController@add');
	Route::match(array('GET', 'POST'),'user-record/edit_visit_record/{id}', 'VisitrecordController@update');
	Route::post('user-record/visitdelete', 'VisitrecordController@massDestroy');

	Route::get('user-record/inquery', 'InqueryController@index');
	Route::match(array('GET', 'POST'),'user-record/add_inquery', 'InqueryController@add');
	Route::match(array('GET', 'POST'),'user-record/edit_inquery/{id}', 'InqueryController@update');
	Route::post('user-record/inquerydelete', 'InqueryController@massDestroy');

	Route::get('schedule', 'ScheduleController@index');
	Route::post('scheduleadd', 'ScheduleController@add');
	Route::post('scheduledelete', 'ScheduleController@scheduledelete');
});
