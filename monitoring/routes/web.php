<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SettingsController;
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


Route::get('/', [RouteController::class, 'Login']);
Route::post('/signin', [Auth::class, 'Login']);
Route::get('/logout', [Auth::class, 'Logout']);


Route::get('/dashboard/unit-owners', [DashboardController::class, 'Unit_Owners']);
Route::get('/dashboard/projects', [DashboardController::class, 'Projects']);
Route::get('/dashboard/units', [DashboardController::class, 'Units']);
Route::get('/dashboard/available-units', [DashboardController::class, 'Available_Units']);
Route::get('/dashboard/occupied-units', [DashboardController::class, 'Occupied_Units']);
Route::get('/dashboard/unpaid-monthly-dues', [DashboardController::class, 'Montly_Dues']);
Route::get('/dashboard/units-per-projects', [DashboardController::class, 'Projects_Per_Units']);
Route::get('/dashboard/accounts', [DashboardController::class, 'Accounts']);
Route::get('/dashboard/units-per-owners', [DashboardController::class, 'Units_Per_Owner']);


Route::get('/dashboard', [RouteController::class, 'Dashboard']);
Route::get('/dashboard/notifs', [DashboardController::class, 'Get_Notifs']);
Route::get('/unit-owners', [RouteController::class, 'Unit_Owners']);
Route::get('/unit-owners-list', [PropertyController::class, 'Unit_Owners']);
Route::get('/search/{search}', [PropertyController::class, 'Search_Owners']);
Route::get('/view_owner_data', [RouteController::class, 'View_Owner_Data']);
Route::get('/view-unit-owner/{id}', [PropertyController::class, 'Display_Unit_Owners_Data']);
Route::get('/view-units-results/{id}', [PropertyController::class, 'Display_Owner_Units']);
Route::get('/unit-owners-display', [PropertyController::class, 'Display_Unit_Owners']);
Route::get('/delete-unit-owner/{id}', [PropertyController::class, 'Delete_Unit_Owner']);
Route::post('/add-unit-owner', [PropertyController::class, 'Create_Unit_Owner']);
Route::post('/add-unit', [PropertyController::class, 'Create_Unit']);
Route::post('/add-unit-rentals', [PropertyController::class, 'Create_Rentals']);
Route::get('/display-current-rental/{id}', [PropertyController::class, 'Display_Current_Rental']);
Route::get('/view-completed-contracts/{id}', [PropertyController::class, 'View_Completed_Contracts']);
Route::get('/view-contract-details/{id}', [PropertyController::class, 'View_Contract_Details']);
Route::get('/edit-rental-details/{id}', [PropertyController::class, 'Edit_Rental_Details']);
Route::post('/edit-rental-details', [PropertyController::class, 'Update_Rental_Details']);
Route::post('/add-asso-dues', [PropertyController::class, 'Create_Asso_Dues']);
Route::get('/delete-rental-details/{id}', [PropertyController::class, 'Delete_Rental_Details']);
Route::get('/end-transaction-rental-details/{id}', [PropertyController::class, 'End_Transaction_Rental_Details']);
Route::get('/pay-asso-dues/{id}', [PropertyController::class, 'Pay_Asso_Dues']);
Route::get('/generate-report', [PropertyController::class, 'Generate_Report']);
Route::get('/accounts', [RouteController::class, 'Accounts']);
Route::get('/settings', [RouteController::class, 'Settings']);
Route::get('/settings/changelog', [SettingsController::class, 'Changelog']);


Route::get('/send-expiry-mail', [PropertyController::class, 'Monitoring']);






Route::post('/add-user', [AccountsController::class, 'Create_Account']);
Route::post('/update-user-account', [AccountsController::class, 'Update_User_Profile']);
Route::get('/get-users', [AccountsController::class, 'User_Accounts']);
Route::get('/user-account/{id}', [AccountsController::class, 'Get_User_Account']);
Route::get('/edit-user-account/{id}', [AccountsController::class, 'Get_User_Data']);
