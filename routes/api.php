<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ContentController;

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\Pdf_materialController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ProfController;
use App\Http\Controllers\UserController;




//public routes

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/login/callback', [SocialiteController::class, 'handleProviderCallback']);




//Protected routes
Route::group(['middleware'=>['auth:sanctum']],function () {



    // AUTH
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('/delete-user', [AuthController::class, 'deleteUser']);

    // USER

    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::patch('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    // ME
    Route::get('/me', [UserController::class, 'get_me']);
    Route::patch('/me', [UserController::class, 'update_me']);
    Route::delete('/me', [UserController::class, 'destroy_me']);

    // USER PHOTO
    Route::get('/me/photo', [UserController::class, 'showImage']);
    Route::post('/me/photo', [UserController::class, 'uploadImage']);
    Route::delete('/me/photo', [UserController::class, 'deleteImage']);




    // Student
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::patch('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    Route::post('/students/search', [StudentController::class, 'search']);
    Route::patch('/students/{id}/change-level', [StudentController::class, 'changeLevel']);
    Route::patch('/students/{id}/change-status', [StudentController::class, 'changeStatus']);
    Route::patch('/students/{id}/add-speciality', [StudentController::class, 'addSpeciality']);
    Route::patch('/students/', [StudentController::class, 'update_me']);




    // Content
    Route::post('/contents', [ContentController::class, 'store']);
    Route::get('/contents', [ContentController::class, 'index']);
    Route::get('/contents/{id}', [ContentController::class, 'show']);
    Route::patch('/{id}', [ContentController::class, 'update']);
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
    Route::patch('/transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'delete']);
    Route::get('/transactions/search', [TransactionController::class, 'search']);




    // Registration
    Route::get('/registrations/{id}', [RegistrationController::class, 'getRegistrationById']);
    Route::get('/registrations', [RegistrationController::class, 'getAllRegistrations']);
    Route::get('/registrations/content-or-user', [RegistrationController::class, 'getRegistrationByContentIdOrUserId']);
    Route::post('/registrations', [RegistrationController::class, 'registerStudent']);
    Route::patch('/registrations/{id}', [RegistrationController::class, 'updateRegistration']);
    Route::delete('/registrations/{id}', [RegistrationController::class, 'cancelRegistration']);


    //wallet
    Route::get('/wallets', [WalletController::class, 'index']);
    Route::post('/wallets', [WalletController::class, 'store']); //Create a new wallet
    Route::get('/wallets/{id}', [WalletController::class, 'show']); // Get a specific wallet by ID
    Route::patch('/wallets', [WalletController::class, 'update']); // Update a specific wallet by ID
    Route::delete('/wallets/{id}', [WalletController::class, 'destroy']); // Delete a specific wallet by ID
    // Increment or subtract balance routes
    Route::patch('/wallets/increment', [WalletController::class, 'incrementBalance']);// Increment the balance of a wallet
    Route::patch('/wallets/subtract', [WalletController::class, 'subtractBalance']);// Subtract the balance of a wallet


    //buy
    Route::get('/buys', [BuyController::class, 'index']);
    Route::post('/buys', [BuyController::class, 'store']);
    Route::get('/buys/{id}', [BuyController::class, 'show']);
    Route::patch('/buys/{id}', [BuyController::class, 'update']);
    Route::delete('/buys/{id}', [BuyController::class, 'destroy']);



    //level
    Route::get('/levels', [LevelController::class, 'index']);
    Route::post('/levels', [LevelController::class, 'store']);
    Route::get('/levels/{id}', [LevelController::class, 'show']);
    Route::patch('/levels/{id}', [LevelController::class, 'update']);
    Route::delete('/levels/{id}', [LevelController::class, 'destroy']);


    //book
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::patch('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);


    //pdf_material
    Route::get('/pdf_materials', [Pdf_materialController::class, 'index']);
    Route::get('/pdf_materials/{id}', [Pdf_materialController::class, 'show']);
    Route::post('/pdf_materials', [Pdf_materialController::class, 'store']);
    Route::patch('/pdf_materials/{id}', [Pdf_materialController::class, 'update']);
    Route::delete('/pdf_materials/{id}', [Pdf_materialController::class, 'destroy']);


    //quizz
    Route::get('/quizzes', [QuizController::class, 'index']);
    Route::get('/quizzes/{id}', [QuizController::class, 'show']);
    Route::post('/quizzes', [QuizController::class, 'store']);
    Route::patch('/quizzes/{id}', [QuizController::class, 'update']);
    Route::delete('/quizzes/{id}', [QuizController::class, 'destroy']);
    Route::get('/quizzes/content/{id}', [QuizController::class, 'getQuizByContentId']);

    //specialty
    Route::get('/specialities', [SpecialityController::class, 'index']);
    Route::get('/specialities/{id}', [SpecialityController::class, 'show']);
    Route::post('/specialities', [SpecialityController::class, 'store']);
    Route::patch('/specialities/{id}', [SpecialityController::class, 'update']);
    Route::delete('/specialities/{id}', [SpecialityController::class, 'destroy']);


    //video
    Route::get('/videos/{id}', [VideoController::class, 'get_video']);
    Route::post('/videos', [VideoController::class, 'upload_video']);
    Route::patch('/videos/{id}', [VideoController::class, 'update_path']);
    Route::delete('/videos/{id}', [VideoController::class, 'delete_video']);



    //prof
    Route::get('/profs', [ProfController::class, 'index']);
    Route::post('/profs', [ProfController::class, 'store']);
    Route::get('/profs/{id}', [ProfController::class, 'show']);
    Route::patch('/profs/{id}', [ProfController::class, 'update']);
    Route::delete('/profs/{id}', [ProfController::class, 'destroy']);
    Route::patch('/profs', [ProfController::class, 'update_me']);



    //Question
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::get('/questions/{id}', [QuestionController::class, 'show']);
    Route::post('/questions', [QuestionController::class, 'store']);
    Route::patch('/questions/{id}', [QuestionController::class, 'update']);
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
    Route::get('/questions/quiz/{id}', [QuestionController::class, 'getQestionsByQuizId']);


    // ANSWER
    Route::get('/answers', [AnswerController::class, 'index']);
    Route::get('/answers/{id}', [AnswerController::class, 'show']);
    Route::post('/answers', [AnswerController::class, 'store']);
    Route::patch('/answers/{id}', [AnswerController::class, 'update']);
    Route::delete('/answers/{id}', [AnswerController::class, 'destroy']);
    Route::get('/answers/question/{id}', [AnswerController::class, 'getAnswersByQuestionId']);

});





