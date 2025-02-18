<?php

use App\Http\Controllers\FetchAppointments;
use App\Http\Controllers\RescheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MpesaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('mpesa/callback', [MpesaController::class, 'callback'])->name('mpesa.callback');
Route::get('/get-appointments', [FetchAppointments::class, 'getAppointments']);
Route::post('/api/reschedule', [RescheduleController::class, 'reschedule']);
Route::get('/calendar-content', function () {
    return view('calendar');
})->name('calendar.content');


