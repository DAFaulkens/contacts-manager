<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::put('contacts/upload', [ContactController::class, 'xmlUpload'])
    ->middleware(['auth:sanctum', 'verified'])->name('contacts.upload');

Route::resource('/contacts', ContactController::class)
    ->middleware(['auth:sanctum', 'verified']);

