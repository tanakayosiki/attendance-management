<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\BreakTimeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/date',[DateController::class,'index']);
Route::middleware('auth')->group(function(){
Route::get('/',[AuthenticatedSessionController::class,'index']);
});
Route::post('/attend',[AuthenticatedSessionController::class,'attend']);
Route::get('/attend',[AuthenticatedSessionController::class,'attend']);
Route::post('/leave',[AuthenticatedSessionController::class,'leave']);
Route::get('/leave',[AuthenticatedSessionController::class,'leave']);
Route::post('/breakin',[BreakTimeController::class,'breakIn']);
Route::get('/breakin',[BreakTimeController::class,'breakIn']);
Route::post('/breakout',[BreakTimeController::class,'breakOut']);
Route::get('/breakout',[BreakTimeController::class,'breakOut']);