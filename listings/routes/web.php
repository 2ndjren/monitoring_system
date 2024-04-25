<?php

use App\Http\Controllers\Agent_Controller;
use App\Http\Controllers\Building_Controller;
use App\Http\Controllers\Route_Controller;
use App\Http\Controllers\Client_Controller;
use App\Http\Controllers\Coordinator_Controller;
use App\Http\Controllers\Dashboard_Controller;
use App\Http\Controllers\Project_Controller;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Route_Controller::class, 'Dashboard']);
Route::get('/contracts', [Route_Controller::class, 'Contracts']);
Route::get('/agents', [Route_Controller::class, 'Agents']);
Route::get('/clients', [Route_Controller::class, 'Clients']);
Route::get('/coordinators', [Route_Controller::class, 'Coordinators']);
Route::get('/projects', [Route_Controller::class, 'Projects']);
Route::get('/buildings', [Route_Controller::class, 'Buildings']);
Route::get('/units', [Route_Controller::class, 'Units']);
Route::get('/properties', [Route_Controller::class, 'properties']);
Route::get('/import', [Route_Controller::class, 'import']);
Route::get('/export', [Route_Controller::class, 'export']);

Route::get('/dashboard/get-data', [Dashboard_Controller::class, 'get_data']);

Route::prefix('/contracts')->group(function () {
    Route::post('/', [Client_Controller::class, 'get_all']);
    Route::post('/add', [Client_Controller::class, 'add']);
    Route::post('/edit', [Client_Controller::class, 'edit']);
    Route::post('/upd', [Client_Controller::class, 'upd']);
    Route::post('/del', [Client_Controller::class, 'del']);
});

Route::prefix('/clients')->group(function () {
    Route::post('/', [Client_Controller::class, 'get_all']);
    Route::post('/add', [Client_Controller::class, 'add']);
    Route::post('/edit', [Client_Controller::class, 'edit']);
    Route::post('/upd', [Client_Controller::class, 'upd']);
    Route::post('/del', [Client_Controller::class, 'del']);
});

Route::prefix('/coordinators')->group(function () {
    Route::post('/', [Coordinator_Controller::class, 'get_all']);
    Route::post('/add', [Coordinator_Controller::class, 'add']);
    Route::post('/edit', [Coordinator_Controller::class, 'edit']);
    Route::post('/upd', [Coordinator_Controller::class, 'upd']);
    Route::post('/del', [Coordinator_Controller::class, 'del']);
});
Route::prefix('/agents')->group(function () {
    Route::post('/', [Agent_Controller::class, 'get_all']);
    Route::post('/add', [Agent_Controller::class, 'add']);
    Route::post('/edit', [Agent_Controller::class, 'edit']);
    Route::post('/upd', [Agent_Controller::class, 'upd']);
    Route::post('/del', [Agent_Controller::class, 'del']);
});

Route::prefix('/projects')->group(function () {
    Route::post('/', [Project_Controller::class, 'get_all']);
    Route::post('/add', [Project_Controller::class, 'add']);
    Route::post('/edit', [Project_Controller::class, 'edit']);
    Route::post('/upd', [Project_Controller::class, 'upd']);
    Route::post('/del', [Project_Controller::class, 'del']);
});
Route::prefix('/buildings')->group(function () {
    Route::post('/', [Building_Controller::class, 'get_all']);
    Route::get('/{id}', [Building_Controller::class, 'get_all_data']);
    Route::post('/add', [Building_Controller::class, 'add']);
    Route::post('/edit', [Building_Controller::class, 'edit']);
    Route::post('/upd', [Building_Controller::class, 'upd']);
    Route::post('/del', [Building_Controller::class, 'del']);
});
Route::prefix('/units')->group(function () {
    // Route::post('/', [Unit_Controller::class, 'get_all']);
    Route::get('/{id}', [Unit_Controller::class, 'get_all_data']);
    Route::post('/add', [Unit_Controller::class, 'add']);
    Route::post('/edit', [Unit_Controller::class, 'edit']);
    Route::post('/upd', [Unit_Controller::class, 'upd']);
    Route::post('/del', [Unit_Controller::class, 'del']);
});
