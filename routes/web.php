<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserMgmtController;

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

route::get('user-dashboard',[UserMgmtController::class,'index'])->name('user-dashboard');
Route::post('/store', [UserMgmtController::class, 'store'])->name('store');
Route::get('/fetchall', [UserMgmtController::class, 'fetchAllUserManagementSystem'])->name('fetchAll');
Route::delete('/delete', [UserMgmtController::class, 'delete'])->name('delete');