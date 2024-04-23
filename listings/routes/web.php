<?php

use App\Http\Controllers\Route_Controller;
use App\Http\Controllers\Client_Controller;
use App\Http\Controllers\Project_Controller;

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
Route::get('/properties', [Route_Controller::class, 'properties']);

Route::prefix('/clients')->group(function () {
    Route::post('/', [Client_Controller::class, 'get_all']);
    Route::post('/add', [Client_Controller::class, 'add']);
    Route::post('/edit', [Client_Controller::class, 'edit']);
    Route::post('/upd', [Client_Controller::class, 'upd']);
    Route::post('/del', [Client_Controller::class, 'del']);
});

Route::prefix('/projects')->group(function () {
    Route::post('/', [Project_Controller::class, 'get_all']);
    Route::post('/add', [Project_Controller::class, 'add']);
    Route::post('/edit', [Project_Controller::class, 'edit']);
    Route::post('/upd', [Project_Controller::class, 'upd']);
    Route::post('/del', [Project_Controller::class, 'del']);
});
