<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function() {
    return response()->json(['message' => 'INNOVARE API', 'status' => 'Connected']);
});

Route::post('/login', 'EmployeesController@login');
// Route::post('/forgotPassword', 'EmployeesController@forgotPassword');
// Route::post('/resetPassword', 'EmployeesController@resetPassword');

Route::group(['middleware' => 'jwt.auth'], function () {
    //Rotas de usuario
    Route::resource('employees', 'EmployeesController');
    Route::resource('clients', 'ClientsController');
    Route::resource('providers', 'ProvidersController');
    Route::resource('taxes', 'TaxesController');
    Route::resource('banks', 'BanksController');
    Route::resource('cost_centers', 'CostCentersController');
    Route::resource('projects', 'ProjectsController');
    Route::resource('billspay', 'BillspayController');
    Route::resource('billsreceive', 'BillsreceiveController');
    Route::resource('alerts', 'AlertsController');

    Route::post('tax/provider/{provider_id}', 'TaxesController@provider');
    Route::post('tax/client/{client_id}', 'TaxesController@client');

    Route::resource('reports', 'ReportsController');

    Route::post('/profile', 'EmployeesController@profile');
    Route::get('/zipcode/{number}', 'FunctionsController@zipcode');
});
