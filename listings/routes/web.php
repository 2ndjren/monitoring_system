<?php

use App\Http\Controllers\Route_Controller;
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

Route::get('dashboard', [Route_Controller::class, 'Dashboard']);
Route::get('agents', [Route_Controller::class, 'Agents']);
Route::get('clients', [Route_Controller::class, 'Clients']);
Route::get('coordinators', [Route_Controller::class, 'Coordinators']);
Route::get('projects', [Route_Controller::class, 'Projects']);
Route::get('properties', [Route_Controller::class, 'properties']);
