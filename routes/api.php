<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserCollection;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PhotoController;


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

//Route::get('/productos/?{name}',[ProductoController::class,'show']); //mostrar todos los registros
Route::get('/productos',[ProductoController::class,'index']); //mostrar todos los registros
Route::get('/photos',[PhotoController::class,'index']); //mostrar todos los registros
Route::post('/productos',[ProductoController::class,'store']); //crear un registro
Route::put('/productos/{id}',[ProductoController::class,'update']); //actualizar un registro
Route::delete('/productos/{id}',[ProductoController::class,'destroy']); //eliminar un registro