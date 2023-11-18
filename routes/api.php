<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CitasController;
use App\Http\Controllers\Api\HorariosController;
use App\Http\Controllers\Api\LogsController;
use App\Http\Controllers\Api\PublicacionesController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;



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
//No requieren autenticacion
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

//Horarios
Route::get('/horarios', [HorariosController::class, 'index']);
Route::post('/horarios', [HorariosController::class, 'store']);




Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::get('/citas', [CitasController::class, 'index']);
Route::get('/citas/create', [CitasController::class, 'create']);

//Proyectos
Route::post('/proyectos/create', [PublicacionesController::class,'store']);
Route::get('/proyectos', [PublicacionesController::class,'index']);
Route::get('/proyectos/{publicacion}', [PublicacionesController::class,'show']);
Route::post('/proyectos/edit', [PublicacionesController::class,'update']);
Route::delete('/proyectos/{publicacion}', [PublicacionesController::class,'destroy']);

//Logs
Route::get('/logs', [LogsController::class,'index']);
Route::get('/logs/users', [LogsController::class,'LogsUserActions']);
Route::get('/logs/proyects', [LogsController::class,'LogsProyectsActions']);
//Requiere Autenticacion
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logoutUser', [AuthController::class, 'destroy'])
                ->name('logoutUser');

    Route::get('/email/verify/{id}/{hash}',[UserController::class,"verifyEmail"])->middleware('signed')->name('verification.verify');


    Route::get('/user', [UserController::class, 'show'])->name('showUser');

    //Citas
    Route::post('/citas',[CitasController::class, 'store']);
    Route::get('/citas/{citas}/edit',[CitasController::class, 'edit']);
    Route::post('/citas/update',[CitasController::class, 'update']);
    Route::get('/citas/user/',[CitasController::class, 'indexUser']);
    Route::delete('/citas/{cita}',[CitasController::class, 'destroy']);
});



