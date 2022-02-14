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
Route::get('productos',[ProductoController::class,'index']); //mostrar todos los registros almacenados en la table Productos
Route::get('productos/{name}',[ProductoController::class,'show']); //devuelve la informacion de un producto buscado por su nombre
Route::get('photos',[PhotoController::class,'create']); //se ejecuta una unica vez, a modo de testing. realiza la peticion http a una api externa, almacena los datos, y luego los muestra
Route::post('productos',[ProductoController::class,'store']); //crea un nuevo registro en la tabla productos. 
Route::put('productos/{id}',[ProductoController::class,'update']); //actualiza los datos del registro indicado por id
Route::delete('productos/{id}',[ProductoController::class,'destroy']); //elimina un registro indicado por el id