<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\User\ListUser;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\Admin\Appointment\ListAppointment;

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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'admin'], function(){
    Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
    Route::get('/users', ListUser::class)->name('admin.user');
    Route::get('/appointment', ListAppointment::class)->name('admin.appointment');
});

