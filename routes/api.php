<?php

use App\Http\Controllers\Api\AdminsController;
use App\Http\Controllers\Api\TicketResponseController;
use App\Http\Controllers\Api\TicketsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtVerify;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
    Route::post('/login',[AdminsController::class,'Login']);
    Route::middleware([JwtVerify::class.':admin'])->post('/register',[AdminsController::class,'Add']);
});

Route::prefix('tickets')->group(function () {
    Route::middleware([JwtVerify::class.':user'])->post('/create',[TicketsController::class,'Add']);
    Route::middleware([JwtVerify::class.':admin'])->get('/list',[TicketsController::class,'GetAll']);
    Route::middleware([JwtVerify::class.':admin,user'])->post('/delete',[TicketsController::class,'Delete']);
    Route::middleware([JwtVerify::class.':admin,user'])->get('/list', [TicketsController::class,'GetAll']);
    Route::middleware([JwtVerify::class.':admin,user'])->get('/details', [TicketsController::class,'Get']);
    Route::middleware([JwtVerify::class.':admin,user'])->post('/update', [TicketsController::class,'Update']);
    Route::middleware([JwtVerify::class.':admin'])->post('/status',[TicketsController::class,'StatusUpdate']);
    Route::middleware([JwtVerify::class.':admin,user'])->post('/update',[TicketsController::class,'Update']);
});

Route::prefix('ticket-response')->group(function () {
    Route::middleware([JwtVerify::class.':admin'])->post('/create',[TicketResponseController::class,'Add']);
    Route::middleware([JwtVerify::class.':admin,user'])->get('/list',[TicketResponseController::class,'GetAll']);
});



