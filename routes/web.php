<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
  
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
include(app_path().'/global_constants.php');
Route::get('/', function () {
    return view('welcome');
});
  
Auth::routes();

  /* 0=Sales,1=Admin,2=Manager,3=Cashier */

/*  Sales Routes List */
  /* jobs */
    Route::resource('jobs', App\Http\Controllers\JobController::class);
    Route::get('jobs/destroy/{encatid?}', [App\Http\Controllers\JobController::class, 'destroy'])->name('jobs.delete');
    Route::get('jobs/update-status/{id}/{status}', [App\Http\Controllers\JobController::class, 'changeStatus'])->name('jobs.status');
    Route::post('jobs/update-price', [App\Http\Controllers\JobController::class, 'updatePrice'])->name('jobs.updatePrice');
  /* jobs */
Route::middleware(['auth', 'user-access:0'])->group(function () {
  
    Route::get('/home', [HomeController::class, 'index'])->name('sales.home');
   
});
  
/*  Admin Routes List */
Route::middleware(['auth', 'user-access:1'])->group(function () {
  
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
});
  
/* Manager Routes List */
Route::middleware(['auth', 'user-access:2'])->group(function () {
  
    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
});
/* Cashier Routes List */
Route::middleware(['auth', 'user-access:3'])->group(function () {
  
    Route::get('/cashier/home', [HomeController::class, 'cashierHome'])->name('cashier.home');
});