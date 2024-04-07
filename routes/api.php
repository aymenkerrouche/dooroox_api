<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


//public routes

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);




//Protected routes
Route::group(['middleware'=>['auth:sanctum']],function () {


    // AUTH
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('/delete-user', [AuthController::class, 'deleteUser']);


    // Student
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    Route::post('/students/search', [StudentController::class, 'search']);
    Route::put('/students/{id}/change-level', [StudentController::class, 'changeLevel']);
    Route::put('/students/{id}/change-status', [StudentController::class, 'changeStatus']);
    Route::put('/students/{id}/add-speciality', [StudentController::class, 'addSpeciality']);



    // Content
    Route::post('/contents', [ContentController::class, 'store']);
    Route::get('/contents', [ContentController::class, 'index']);
    Route::get('/contents/{id}', [ContentController::class, 'show']);
    Route::put('/{id}', [ContentController::class, 'update']);
    Route::get('/search', [ContentController::class, 'search']);
    Route::get('/teacher/{creatorId}', [ContentController::class, 'getTeacherContents']);
    Route::delete('/contents/{id}', [ContentController::class, 'destroy']);


    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'getMyWishlist']);
    Route::get('/wishlist/{userId}', [WishlistController::class, 'getStudentWishlist']);
    Route::post('/wishlist/{contentId}', [WishlistController::class, 'addToWishlist']);
    Route::delete('/wishlist/{contentId}', [WishlistController::class, 'removeFromWishlist']);



    // Transaction
    Route::post('/transactions', [TransactionController::class, 'create']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'delete']);
    Route::get('/transactions/search', [TransactionController::class, 'search']);




    // Registration
    Route::get('/registrations/{id}', [RegistrationController::class, 'getRegistrationById']);
    Route::get('/registrations', [RegistrationController::class, 'getAllRegistrations']);
    Route::get('/registrations/content-or-user', [RegistrationController::class, 'getRegistrationByContentIdOrUserId']);
    Route::post('/registrations', [RegistrationController::class, 'registerStudent']);
    Route::put('/registrations/{id}', [RegistrationController::class, 'updateRegistration']);
    Route::delete('/registrations/{id}', [RegistrationController::class, 'cancelRegistration']);



    Route::prefix('wallets')->group(function () {
        Route::get('/', [WalletController::class, 'index']);
        Route::post('/{id}/increment', [WalletController::class, 'store']); //Create a new wallet
        Route::get('/{id}', [WalletController::class, 'show']); // Get a specific wallet by ID
        Route::put('/{id}', [WalletController::class, 'update']); // Update a specific wallet by ID
        Route::delete('/{id}', [WalletController::class, 'destroy']); // Delete a specific wallet by ID

        // Increment or subtract balance routes
        Route::put('/{id}/increment', [WalletController::class, 'incrementBalance']);// Increment the balance of a wallet
        Route::put('/{id}/subtract', [WalletController::class, 'subtractBalance']);// Subtract the balance of a wallet
    });

});





