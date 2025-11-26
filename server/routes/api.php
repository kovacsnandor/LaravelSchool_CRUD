<?php

use App\Http\Controllers\PlayingsportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SchoolclassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//endpoint
Route::get('/x', function(){
    return 'API';
});


//region users
//User kezelés, login, logout
//Mindenki
Route::post('users/login', [UserController::class, 'login']);
Route::post('users/logout', [UserController::class, 'logout']);
Route::post('users', [UserController::class, 'store']);

//Admin:
//minden user lekérdezése
Route::get('users', [UserController::class, 'index'])
    ->middleware('auth:sanctum', 'ability:admin');
//Egy user lekérése
Route::get('users/{id}', [UserController::class, 'show'])
    ->middleware('auth:sanctum', 'ability:admin');
//User adatok módosítása
Route::patch('users/{id}', [UserController::class, 'update'])
->middleware('auth:sanctum', 'ability:admin');
//User törlés
Route::delete('users/{id}', [UserController::class, 'destroy'])
->middleware('auth:sanctum', 'ability:admin');

//User self (Amit a user önmagával csinálhat) parancsok
Route::delete('usersme', [UserController::class, 'destroySelf'])
->middleware('auth:sanctum', 'ability:usersme:delete');

Route::patch('usersme', [UserController::class, 'updateSelf'])
->middleware('auth:sanctum', 'ability:usersme:patch');

Route::get('usersme', [UserController::class, 'indexSelf'])
    ->middleware('auth:sanctum', 'ability:usersme:get');
//endregion



//region Palyingsport
Route::get('playingsports', [PlayingsportController::class, 'index']);
Route::get('playingsports/{id}', [PlayingsportController::class, 'show']);
Route::post('playingsports', [PlayingsportController::class, 'store']);
Route::patch('playingsports/{id}', [PlayingsportController::class, 'update']);
Route::delete('playingsports/{id}', [PlayingsportController::class, 'destroy']);
//endregion

//region Student
Route::get('students', [StudentController::class, 'index']);
Route::get('students/{id}', [StudentController::class, 'show']);
Route::post('students', [StudentController::class, 'store']);
Route::patch('students/{id}', [StudentController::class, 'update']);
Route::delete('students/{id}', [StudentController::class, 'destroy']);
//endregion

//region Schoolclass
Route::get('schoolclasses', [SchoolclassController::class, 'index']);
Route::get('schoolclasses/{id}', [SchoolclassController::class, 'show']);
Route::post('schoolclasses', [SchoolclassController::class, 'store']);
Route::patch('schoolclasses/{id}', [SchoolclassController::class, 'update']);
Route::delete('schoolclasses/{id}', [SchoolclassController::class, 'destroy']);
//endregion
