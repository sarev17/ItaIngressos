<?php

use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Register\RegisterController;
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

Route::get('/',[HomeController::class,'index']);

// Auth::routes(['verify'=>true]);
Auth::routes();

Route::get('register-organizer',function(){
    return view('registration.register_organizer');
});
Route::resource('registeruser', RegisterController::class);
Route::get('event-detail/{id}',[EventController::class,'detail'])->name('event-detail');
Route::middleware('auth')->group(function(){
    Route::prefix('organizer')->group(function(){
        Route::get('panel',[OrganizerController::class,'panel'])->name('panel-organizer');
        Route::resource('event', EventController::class);
    });
});
