<?php
/* auth */
Auth::routes();

/* Role & Permission Manage */
Route::prefix('uac')->group(function () {
	Route::group(['middleware' => ['auth']], function() {
		Route::resource('roles', 'RoleController');
		Route::resource('permissions', 'PermissionController');
		Route::resource('users', 'UserController');
	});
});

/* Home */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

/* register */
Route::get('/register', '\App\Http\Controllers\Auth\RegisterController@index')->name('register');
Route::post('register', '\App\Http\Controllers\Auth\RegisterController@register')->name('register');
Route::get('/getHospByProv', '\App\Http\Controllers\Auth\RegisterController@getHospByProv')->name('getHospByProv');

/* Form */
//Route::get('/confirmForm', 'ConfirmFormController@create')->name('confirmForm');
Route::post('chConfirmStatus', 'ConfirmFormController@changeStatus')->name('chConfirmStatus');
Route::post('chConfirmStatusServerSide', 'ConfirmFormController@changeStatusSeverSide')->name('chConfirmStatusServerSide');
Route::post('changePtStatus', 'ConfirmFormController@changePtStatus')->name('changePtStatus');
Route::post('changeNewsStatus', 'ConfirmFormController@changeNewsStatus')->name('changeNewsStatus');
Route::post('changeDcStatus', 'ConfirmFormController@changeDcStatus')->name('changeDcStatus');
Route::get('/verifyForm', 'VerifyFormController@create')->name('verifyForm');
Route::get('/screen-pui', array('as' => 'screenpui.create', 'uses' => 'ScreenPUIController@create'));
Route::post('/screen-pui', array('as' => 'screenpui.store', 'uses' => 'ScreenPUIController@store'));
Route::get('/screen-pui/edit/{id}', array('as' => 'screenpui.edit', 'uses' => 'ScreenPUIController@edit'));
Route::post('/screen-pui/update/', array('as' => 'screenpui.update', 'uses' => 'ScreenPUIController@update'));
Route::get('/del-screen-pui/{id}', array('as' => 'screenpui.delete', 'uses' => 'ScreenPUIController@destroy'));
Route::post('/ListHosp', array('as' => 'screenpui.fetchHos', 'uses' => 'ScreenPUIController@Sat_FetcHos'));
Route::get('/sat-delete/{id}', array('as' => 'screenpui.satdel', 'uses' => 'ScreenPUIController@Delete_Sat'));
// Route::get('/hos-test', function () {
// 	return view('hospital.screenhos');
// });
/* state quarantine */
//Route::get('/List-State-Quarantine', array('as' => 'list.state_quarantine', 'uses' => 'StateQuarantineController@index'));

Route::get('/confirmForm/{id}', 'ConfirmFormController@create')->name('confirmForm');
Route::post('confirmCase', 'ConfirmFormController@addConfirmCase')->name('confirmCase');
//Route::get('/verifyForm', 'VerifyFormController@create')->name('verifyForm');

/*List the data older version */
Route::get('/satt/list', 'InvestListController@satListData')->name('satList');
Route::resource('investList', 'InvestListController');

/* fetch district, fetch sub-district */
Route::post('country/city', 'ConfirmFormController@cityFetch')->name('cityFetch');
Route::post('province/district', 'ConfirmFormController@districtFetch')->name('districtFetch');
Route::post('province/district/sub-district', 'ConfirmFormController@subDistrictFetch')->name('subDistrictFetch');
Route::post('hospitalFetch', 'InvestController@hospitalFetch')->name('hospitalFetch');
Route::post('hospital/fetch/hospital', 'InvestController@hospitalFetchByDistrict2Digit')->name('hospitalFetchByDistrict2Digit');
Route::post('hospital/refer/store', 'InvestController@storeReferOut')->name('store.refer');

/* Contact */
Route::get('/allcasecontacttable', 'ContactController@allcasecontacttable')->name('allcasecontacttable');
Route::get('/detailcontact/contact_id/{contact_id}', 'ContactController@detailcontact')->name('detailcontact');
Route::get('/contacttable/id/{id}', 'ContactController@contacttable')->name('contacttable');
Route::get('/deletecontact/id/{id}', 'ContactController@deletecontact')->name('deletecontact');
Route::get('/followuptablespui/typid/{typid}/id/{id}', 'ContactController@followuptablespui')->name('followuptablespui');
Route::get('/followuptablescon/typid/{typid}/id/{id}', 'ContactController@followuptablescon')->name('followuptablescon');

Route::get('/puifollowtable', 'ContactController@puifollowtable')->name('puifollowtable');
Route::get('/contactfollowtable', 'ContactController@contactfollowtable')->name('contactfollowtable');
	Route::get('/contact/list', 'ListContactController@index')->name('list-data.contact');
	Route::post('ch-status-con', 'ListContactController@chStatus')->name('ch-status-con');
Route::get('/addcontact/id/{id}', 'ContactController@addcontact')->name('addcontact');
Route::get('/addcontactnonsatid', 'ContactController@addcontactnonsatid')->name('addcontactnonsatid');
Route::get('/allcontacttable', 'ContactController@allcontacttable')->name('allcontacttable');
// Route::get('/editcontact/pui_id/{pui_id}/contact_rid/{contact_rid}', 'ContactController@editcontact')->name('editcontact');
Route::get('/editcontact/id/{id}', 'ContactController@editcontact')->name('editcontact');
Route::post('/addcontact/fetch', 'ContactController@fetch')->name('dropdown.fetch');
Route::post('/addcontact/fetchD', 'ContactController@fetchD')->name('dropdown.fetchD');
Route::post('/addcontact/fetchos', 'ContactController@fetchos')->name('dropdown.fetchos');
Route::get('/followup/typid/{typid}/id/{id}', 'ContactController@followup')->name('followup');

Route::get('/addfollowuppui/typid/{typid}/id/{id}', 'ContactController@addfollowuppui')->name('addfollowuppui');
Route::get('/addfollowupcon/typid/{typid}/id/{id}', 'ContactController@addfollowupcon')->name('addfollowupcon');

Route::post('/followup/fetchos', 'ContactController@fetchos')->name('dropdown.fetchos');
Route::post('/followupinsert', 'ContactController@followupinsert')->name('followupinsert');
Route::post('/contactinsert', 'ContactController@contactinsert')->name('contactinsert');
Route::post('/contactedit', 'ContactController@contactedit')->name('contactedit');
Route::post('/contact_st_update', 'ContactController@contactstupdate')->name('contact_st_update');
Route::post('/allcontactstupdate', 'ContactController@allcontactstupdate')->name('allcontactstupdate');

route::get('contactexport/id/{id}', 'ExportContactController@export')->name('contactexport');

Route::get('/colab/send/{id}', 'ListContactController@colabSend')->name('colab.send');
Route::get('/colab/result/{id}', 'ListContactController@colabResult')->name('colab.result');
Route::get('postGuzzleRequest', 'ListContactController@postGuzzleRequest')->name('postGuzzleRequest');

// excel download
route::post('satexport', 'ExportSATController@satexport')->name('satexport');

//Route::get('/allexport', 'ExportExcelController@alltableexport')->name('allexport');
Route::get('/allcontactexport', 'ExportContactController@allcontactexport')->name('allcontactexport');

Route::post('/exportcontactbyday', 'ExportContactbyDayController@exportcontactbyday')->name('exportcontactbyday');
/* Logout */
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

/* Route to under construction page */
Route::group(['middleware' => 'under-construction'], function () {
	Route::get('/live-site', function() {
		echo 'content!';
	})->name('live-site');
});

/* list-data => datatable */
Route::group(['middleware' => ['auth']], function() {
	/* screen url */
	Route::get('/pui/screen', function () {
		$url = 'http://viral.ddc.moph.go.th/viral/screen-hosp/index.php';
		return Redirect::to($url);
	})->name('pui-screen');

	/* List data */
	Route::get('/invest/list', 'ListInvestController@index')->name('list-data.invest');
	Route::get('/sat/list', 'ListSatController@index')->name('list-data.sat');

	/* moaal change status on context menu */
	Route::post('ch-status', 'ListInvestController@chStatus')->name('ch-status');
	Route::post('chPtStatus', 'ListInvestController@chPtStatus')->name('chPtStatus');
	Route::post('chNewsStatus', 'ListInvestController@chNewsStatus')->name('chNewsStatus');
	Route::post('chDcStatus', 'ListInvestController@chDcStatus')->name('chDcStatus');
	/* modal refer out */
	Route::post('refer', 'ListInvestController@referOut')->name('refer');
	/* modal delete on context menu */
	Route::post('invest/delete', 'ListInvestController@softDeleteInvest')->name('invest.delete');

	/* invest */
	Route::get('/invest/create/{id}', 'InvestController@create')->name('invest.create');
	Route::post('invest/store', 'InvestController@store')->name('invest.store');
	Route::get('invest/download/invest/{id}', 'InvestController@downloadInvestFile')->name('invest.downloadInvestFile');
	Route::get('invest/download/xray/{id}', 'InvestController@downloadXrayFile')->name('invest.downloadXrayFile');
	Route::get('/colab/send/{id}', 'ListInvestController@colabSend')->name('colab.send');
	Route::get('/colab/result/{id}', 'ListInvestController@colabResult')->name('colab.result');

	/* map */
	Route::get('/clusters/circle', 'covidController@index')->name('maps.circle');
	Route::get('/clusters/doughnut', 'covidController@clusters')->name('maps.doughnut');

	/* Export */
	Route::get('invest/export', 'ListInvestController@export')->name('iep');
	Route::get('epi', function() {
		return view('export.invest');
	});
	Route::get('/getFile/{file}', 'InvestController@downloadFile');
	Route::get('/checker/{file}', 'ExportController@checkerFile')->name('checker');
	Route::get('/export', 'ExportController@exportPage')->name('export-page');
	Route::post('export', 'ExportController@exportFastExcel')->name('export.search');
	Route::get('/export/{file_name}', 'ExportController@downloadFile')->name('export.file');

	/* log */
	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

	/*
	Route::get('/einvest', function(App\Exports\InvestExport $export) {
		return $export->download('inv.xlsx');
	});
	Route::get('/invest/ept', 'ListInvestController@exportToExcel');
	*/

	Route::resource('item', 'InvestController');
	Route::get('/file/{id}', 'FilesUploadController@index')->name('file.list');
	Route::post('/file/store', 'FilesUploadController@store')->name('file.store');
	Route::get('/file/download/{id}', 'FilesUploadController@download')->name('file.download');
	Route::post('/file/delete', 'FilesUploadController@softDeleteFileUpload')->name('file.delete');
	Route::get('/pjx10', 'InvestController@migrateFileUpload')->name('pjx10');
});

/* DashBoardGraph */
Route::prefix('dashboardgraph')->group(function () {
	Route::group(['middleware' => ['auth']], function() {
		Route::get('/', array('as' => 'dashboardgraph.index', 'uses' => 'DashboardGraphController@index'));
	});
});

Route::resource('hospital', 'HospitalController');

Route::group(['middleware' => ['auth']], function() {
	Route::get('/pjx', function() {
		return view('export.invest');
	});

	Route::get('/testConn', function() {
		return view('test.pj2');
	});

});

/* By Pass Login */
Route::get('/auth', array('as' => 'check-auth', 'uses' => 'Auth\LoginController@get_check_auth'));
