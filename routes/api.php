<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CitasController;
use App\Http\Controllers\Api\HorariosController;
use App\Http\Controllers\api\PublicacionesController;
use App\Http\Controllers\Api\UserController;
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
//No requieren autenticacion
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

//Horarios
Route::get('/horarios', [HorariosController::class, 'index']);
Route::post('/horarios', [HorariosController::class, 'store']);

//Citas
Route::get('/citas', [CitasController::class, 'index']);
Route::get('/citas/create', [CitasController::class, 'create']);

//Proyectos
Route::post('/proyectos/create', [PublicacionesController::class,'store']);
Route::get('/proyectos', [PublicacionesController::class,'index']);

//Requiere Autenticacion
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logoutUser', [AuthController::class, 'destroy'])
                ->name('logoutUser');
    Route::get('/user', [UserController::class, 'show'])->name('showUser');

    //Citas
    Route::post('/citas',[CitasController::class, 'store']);
    Route::get('/citas/{citas}/edit',[CitasController::class, 'edit']);
    Route::post('/citas/update',[CitasController::class, 'update']);
    Route::get('/citas/user/',[CitasController::class, 'indexUser']);
    Route::delete('/citas/{cita}',[CitasController::class, 'destroy']);
});

