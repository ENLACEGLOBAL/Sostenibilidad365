<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/',  [HomeController::class, 'ingresar'])->name('login');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/uploadFile', [App\Http\Controllers\HomeController::class, 'uploadFile'])->name('uploadFile');

//administrador
Route::get('/showCreateCompanies', [App\Http\Controllers\HomeController::class, 'show_create_companies'])->name('showCreateCompanies');
Route::post('/create_company',[App\Http\Controllers\HomeController::class, 'create_company'])->name('create_company');

//subir excel
Route::get('/showUploadPlantilla', [App\Http\Controllers\HomeController::class, 'show_upload_plantilla'])->name('showUploadPlantilla');