<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Auth;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RouteController;
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


Route::get('/login', [RouteController::class, 'Login']);
Route::post('/signin', [Auth::class, 'Login']);
Route::get('/logout', [Auth::class, 'Logout']);

Route::get('/dashboard', [RouteController::class, 'Dashboard']);
Route::get('/unit-owners', [RouteController::class, 'Unit_Owners']);
Route::get('/unit-owners-list', [PropertyController::class, 'Unit_Owners']);
Route::get('/search/{search}', [PropertyController::class, 'Search_Owners']);
Route::get('/view_owner_data', [RouteController::class, 'View_Owner_Data']);
Route::get('/view-unit-owner/{id}', [PropertyController::class, 'Display_Unit_Owners_Data']);
Route::get('/view-units-results/{id}', [PropertyController::class, 'Display_Owner_Units']);
Route::get('/unit-owners-display', [PropertyController::class, 'Display_Unit_Owners']);
// Route::post('/delete-unit-owner', [PropertyController::class, 'Delete_Unit_Owner']);
Route::post('/add-unit-owner', [PropertyController::class, 'Create_Unit_Owner']);
Route::post('/add-unit', [PropertyController::class, 'Create_Unit']);
Route::post('/add-unit-rentals', [PropertyController::class, 'Create_Rentals']);
Route::get('/display-current-rental/{id}', [PropertyController::class, 'Display_Current_Rental']);
Route::get('/accounts', [RouteController::class, 'Accounts']);
Route::get('/settings', [RouteController::class, 'Settings']);






Route::post('/add-user', [AccountsController::class, 'Create_Account']);
Route::get('/get-users', [AccountsController::class, 'User_Accounts']);
Route::get('/user-account/{id}', [AccountsController::class, 'Get_User_Account']);
