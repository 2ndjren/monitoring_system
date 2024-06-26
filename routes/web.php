<?php

use App\Http\Controllers\Account_Controller;
use App\Http\Controllers\Agent_Controller;
use App\Http\Controllers\Auth_Controller;
use App\Http\Controllers\Building_Controller;
use App\Http\Controllers\Route_Controller;
use App\Http\Controllers\Client_Controller;
use App\Http\Controllers\Contract_Controller;
use App\Http\Controllers\Coordinator_Controller;
use App\Http\Controllers\Dashboard_Controller;
use App\Http\Controllers\File_Controller;
use App\Http\Controllers\History_Controller;
use App\Http\Controllers\Notification_Controller;
use App\Http\Controllers\Project_Controller;
use App\Http\Controllers\Property_Controller;
use App\Http\Controllers\Unit_Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Route_Controller::class, 'Signin']);
Route::get('/dashboard', [Route_Controller::class, 'Dashboard']);
Route::get('/accounts', [Route_Controller::class, 'Account']);
Route::get('/contracts', [Route_Controller::class, 'Contracts']);
Route::get('/history', [Route_Controller::class, 'History']);
Route::get('/agents', [Route_Controller::class, 'Agents']);
Route::get('/clients', [Route_Controller::class, 'Clients']);
Route::get('/coordinators', [Route_Controller::class, 'Coordinators']);
Route::get('/import', [Route_Controller::class, 'import']);
Route::get('/export', [Route_Controller::class, 'export']);

Route::get('/dashboard/get-data', [Dashboard_Controller::class, 'get_data']);
Route::get('/dashboard/contracts', [Dashboard_Controller::class, 'Expiring_Contracts']);
Route::get('/dashboard/contracts-dues', [Dashboard_Controller::class, 'Dues']);

Route::prefix('/contracts')->group(function () {
    Route::post('/', [Contract_Controller::class, 'get_all']);
    Route::post('/get-locations', [Contract_Controller::class, 'get_locations']);
    Route::post('/get-location', [Contract_Controller::class, 'get_location']);
    Route::post('/add', [Contract_Controller::class, 'add']);
    Route::post('/payment', [Contract_Controller::class, 'payment']);
    Route::post('/edit', [Contract_Controller::class, 'edit']);
    Route::post('/upd', [Contract_Controller::class, 'upd']);
    Route::post('/del', [Contract_Controller::class, 'del']);
    Route::get('/select-projects', [Contract_Controller::class, 'selectProjects']);
    Route::get('/select-buildings/{id}', [Contract_Controller::class, 'selectBuilding']);
    Route::get('/units/{id}', [Contract_Controller::class, 'selectUnits']);
    Route::get('/selections', [Contract_Controller::class, 'selections']);
});

Route::prefix('/history')->group(function () {
    Route::post('/', [History_Controller::class, 'get_all']);
    Route::post('/add', [History_Controller::class, 'add']);
    Route::post('/payment', [History_Controller::class, 'payment']);
    Route::post('/edit', [History_Controller::class, 'edit']);
    Route::post('/upd', [History_Controller::class, 'upd']);
    Route::post('/del', [History_Controller::class, 'del']);
    Route::get('/select-projects', [History_Controller::class, 'selectProjects']);
    Route::get('/select-buildings/{id}', [History_Controller::class, 'selectBuilding']);
    Route::get('/units/{id}', [History_Controller::class, 'selectUnits']);
    Route::get('/selections', [History_Controller::class, 'selections']);
});

Route::prefix('/clients')->group(function () {
    Route::post('/', [Client_Controller::class, 'get_all']);
    Route::post('/edit', [Client_Controller::class, 'edit']);
    Route::post('/upd', [Client_Controller::class, 'upd']);
    Route::post('/del', [Client_Controller::class, 'del']);
});

Route::prefix('/coordinators')->group(function () {
    Route::post('/', [Coordinator_Controller::class, 'get_all']);
    Route::post('/edit', [Coordinator_Controller::class, 'edit']);
    Route::post('/upd', [Coordinator_Controller::class, 'upd']);
    Route::post('/del', [Coordinator_Controller::class, 'del']);
});

Route::prefix('/agents')->group(function () {
    Route::post('/', [Agent_Controller::class, 'get_all']);
    Route::post('/edit', [Agent_Controller::class, 'edit']);
    Route::post('/upd', [Agent_Controller::class, 'upd']);
    Route::post('/del', [Agent_Controller::class, 'del']);
});

Route::prefix('/file')->group(function () {
    Route::post('/import', [File_Controller::class, 'Import']);
    Route::get('/export', [File_Controller::class, 'Export']);
});
Route::prefix('/')->group(function () {
    Route::post('loggingin', [Auth_Controller::class, 'SignIn']);
    Route::get('logout', [Auth_Controller::class, 'SignOut']);
});

Route::prefix('/account')->group(function () {
    Route::post('/data', [Account_Controller::class, 'get_all']);
    Route::post('/add', [Account_Controller::class, 'add']);
    Route::get('/edit/{id}', [Account_Controller::class, 'edit']);
    Route::post('/upd', [Account_Controller::class, 'upd']);
    Route::post('/del', [Account_Controller::class, 'del']);
});