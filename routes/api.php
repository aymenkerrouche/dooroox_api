<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\RegistrationController;
use App\Models\Prof;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


//public routes
Route::post('/signUp', [AuthController::class, 'signUp']);
Route::post('/signIn', [AuthController::class, 'signIn']);




Route::post('/profs', function (){
  return Prof::all();
});

Route::get('/schools', function (){
  return School::all();
});

Route::get('/students', function (){
  return Student::all();
});




//Protected routes
Route::group(['middleware'=>['auth:sanctum']],function () {

  // User
  Route::get('/user', [AuthController::class, 'user']);
  Route::patch('/user', [AuthController::class, 'update']);
  Route::post('/logout', [AuthController::class, 'logout']);


    // Routes for registration
    Route::get('/registrations/{id}', [RegistrationController::class, 'getRegistrationById']);
    Route::get('/registrations', [RegistrationController::class, 'getAllRegistrations']);
    Route::get('/registrations/content-or-user', [RegistrationController::class, 'getRegistrationByContentIdOrUserId']);
    Route::post('/registrations', [RegistrationController::class, 'registerStudent']);
    Route::put('/registrations/{id}', [RegistrationController::class, 'updateRegistration']);
    Route::delete('/registrations/{id}', [RegistrationController::class, 'cancelRegistration']);

});


//content
Route::apiResource('/content', ContentController::class);




