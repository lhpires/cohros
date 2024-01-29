<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [UserAuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::get('/validateAuth', [UserAuthController::class, 'validateToken']);

    // Contacts
    Route::get('/contacts',[ContactController::class,'index'])->name('contact.list');
    Route::get('/contacts/{id}',[ContactController::class,'show'])->name('contact.show');

    Route::post('/contacts',[ContactController::class,'store'])->name('contact.store');
    Route::put('/contacts/{id}',[ContactController::class,'update'])->name('contact.update');

    Route::delete('/contacts/{contact:id}',[ContactController::class,'destroy'])->name('contact.delete');

    // Phone Numbers
    Route::delete('/phoneNumbers/{phoneNumber:id}',[PhoneNumberController::class,'destroy'])->name('phone.delete');
});
