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

Auth::routes();

/* Home */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

/* Form */

Route::get('/confirmForm', 'ConfirmFormController@create')->name('confirmForm');
Route::post('chConfirmStatus', 'ConfirmFormController@changeStatus')->name('chConfirmStatus');
Route::get('/verifyForm', 'VerifyFormController@create')->name('verifyForm');

Route::get('/screen-pui', array(
						'as'   => 'screenpui.create',
						'uses' => 'ScreenPUIController@create'
					));
Route::post('/screen-pui', array(
						'as'   => 'screenpui.store',
						'uses' => 'ScreenPUIController@store'
					));
Route::get('/screen-pui/edit/{id}', array(
						'as'   => 'screenpui.edit',
						'uses' => 'ScreenPUIController@edit'
					));
Route::post('/screen-pui/update/', array(
						'as'   => 'screenpui.update',
						'uses' => 'ScreenPUIController@update'
					));
Route::get('/del-screen-pui/{id}', array(
						'as'   => 'screenpui.delete',
						'uses' => 'ScreenPUIController@destroy'
					));
Route::post('/ListHosp', array(
						'as'   => 'screenpui.fetchHos',
						'uses' => 'ScreenPUIController@Sat_FetcHos'
					));

Route::get('/confirmForm/{id}', 'ConfirmFormController@create')->name('confirmForm');
Route::post('confirmCase', 'ConfirmFormController@addConfirmCase')->name('confirmCase');
//Route::get('/verifyForm', 'VerifyFormController@create')->name('verifyForm');


/*List the data */
Route::get('/sat/list', 'InvestListController@satListData')->name('satList');
Route::resource('investList', 'InvestListController');

/* fetch district, fetch sub-district */
Route::post('country/city', 'ConfirmFormController@cityFetch')->name('cityFetch');
Route::post('province/district', 'ConfirmFormController@districtFetch')->name('districtFetch');
Route::post('province/district/sub-district', 'ConfirmFormController@subDistrictFetch')->name('subDistrictFetch');

/* Auth */
Route::group(['middleware' => ['auth']], function() {
	Route::resource('roles', 'RoleController');
	Route::resource('users', 'UserController');
});


/* Contact */
Route::get('/allcasecontacttable', 'ContactController@allcasecontacttable')->name('allcasecontacttable');
Route::get('/detailcontact/contact_id/{contact_id}', 'ContactController@detailcontact')->name('detailcontact');
Route::get('/contacttable/id/{id}', 'ContactController@contacttable')->name('contacttable');
Route::get('/contactfollowtable/contact_id/{contact_id}', 'ContactController@contactfollowtable')->name('contactfollowtable');
Route::get('/addcontact/id/{id}', 'ContactController@addcontact')->name('addcontact');
Route::get('/editcontact/contact_id/{contact_id}', 'ContactController@editcontact')->name('editcontact');
Route::post('/addcontact/fetch', 'ContactController@fetch')->name('dropdown.fetch');
Route::post('/addcontact/fetchD', 'ContactController@fetchD')->name('dropdown.fetchD');
Route::post('/addcontact/fetchos', 'ContactController@fetchos')->name('dropdown.fetchos');
Route::get('/followupcontact/contact_id/{contact_id}', 'ContactController@followupcontact')->name('followupcontact');
Route::post('/followupcontact/fetchos', 'ContactController@fetchos')->name('dropdown.fetchos');
Route::post('/followupcontactinsert', 'ContactController@followupcontactinsert')->name('followupcontactinsert');
Route::post('/contactinsert', 'ContactController@contactinsert')->name('contactinsert');
Route::post('/contactedit', 'ContactController@contactedit')->name('contactedit');
// excel download
Route::get('/export_excel', 'ExportExcelController@alltable')->name('export_excel');
Route::post('/export_excel', 'ExportExcelController@index')->name('export_excel');
Route::get('/allexport', 'ExportExcelController@alltableexport')->name('allexport');
Route::post('/allexport', 'ExportExcelController@indexallexcel')->name('allexport');
// Route::get('/export_excel', 'ExportExcelController@index')->name('export_excel');
// Route::post('/export_excel/excel', 'ExportExcelController@export')->name('export_excel.excel');

/* destroy */
Route::resource('item', 'InvestListController');

/* Logout */
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

/* Route to under construction page */
Route::group(['middleware' => 'under-construction'], function () {
	Route::get('/live-site', function() {
		echo 'content!';
	})->name('live-site');
});

/* test for test by talek team */
Route::get('/test', 'TestController@store')->name('test');
