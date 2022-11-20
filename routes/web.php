<?php

use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Payment\IuguActionsController;
use App\Http\Controllers\Payments\MercadoPagoController;
use App\Http\Controllers\Register\RegisterController;
use App\Http\Controllers\TicketsController;
use App\Models\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

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

Route::get('/',[HomeController::class,'index'])->name('index');

// Auth::routes(['verify'=>true]);
Auth::routes();

Route::get('register-organizer',function(){
    return view('registration.register_organizer');
});


Route::prefix('ajax')->group(function () {
    Route::get('search-events', function () {
        return view('ajax.searchbar.events-search-controller');
    })->name('search-events');
});

Route::resource('registeruser', RegisterController::class);
Route::resource('tickets',TicketsController::class);
Route::prefix('payment')->group(function(){
    Route::post('confirm-ticket-payment',[MercadoPagoController::class,'paymentTicketConfirm']
    )->name('payment-ticket-confirm');
});
Route::get('event-detail/{id}',[EventController::class,'detail'])->name('event-detail');
Route::middleware('auth')->group(function(){
    Route::prefix('organizer')->group(function(){
        Route::get('panel',[OrganizerController::class,'panel'])->name('home');
        Route::resource('event', EventController::class);
    });
});
Route::get('verify-payment/{id}',[MercadoPagoController::class,'verifyPayment']);
Route::get('confirm-pay',function(){
    Alert::success('Pagamento Confirmado!','Você receberá um email com os dados do ingresso');
    return redirect()->route('index');
});
Route::get('test',function(){
    return view('test');
});
Route::get('send-code-email/{email}', [EventController::class, 'sendCode']);

Route::middleware(['auth'])->group(function () {
    Route::get('checkin',function(){
        return view('organizer.checkin');
    });
    Route::get('ckeckin-ticket/{code}',[EventController::class,'checkInTicket']);
    Route::post('update-pix',[OrganizerController::class,'updatePix']);
});

