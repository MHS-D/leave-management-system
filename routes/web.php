<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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

Route::get('login', [AuthController::class, 'loginView'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('change-lang/{lang}', [DashboardController::class, 'changeLocale'])->name('locale.change');


	Route::prefix('users')->controller(UsersController::class)->group(function () {
		Route::get('statistics', 'getStatistics')->name('users.statistics');
		Route::prefix('export')->group(function () {
			Route::post('excel', 'exportExcel')->name('users.export.excel');
			Route::post('csv', 'exportCsv')->name('users.export.csv');
			Route::post('pdf', 'exportPdf')->name('users.export.pdf');
		});
	});

	Route::resource('users', UsersController::class);
	Route::resource('leave-requests', LeaveRequestController::class);


    Route::get('get-request-info/{leave_request}', [LeaveRequestController::class,'getRequestInfo'])->name('request.getInfo');
    Route::post('update-project-status', [LeaveRequestController::class,'updateStatus'])->name('request.updateStatus');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

});
