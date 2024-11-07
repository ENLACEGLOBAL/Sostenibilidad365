<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/uploadFile', [App\Http\Controllers\HomeController::class, 'uploadFile'])->name('uploadFile');

//administrador
Route::get('/showCreateCompanies', [App\Http\Controllers\HomeController::class, 'show_create_companies'])->name('showCreateCompanies');
Route::post('/create_company',[App\Http\Controllers\HomeController::class, 'create_company'])->name('create_company');

//subir excel
Route::get('/showUploadPlantilla', [App\Http\Controllers\HomeController::class, 'show_upload_plantilla'])->name('showUploadPlantilla');
