<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUpload;

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

Route::get('/upload-file', [FileUpload::class, 'createForm'])->middleware(['auth'])->name('fileUpload');;
Route::post('/upload-file', [FileUpload::class, 'fileUpload'])->middleware(['auth'])->name('fileUpload');

Route::get('/visualizer', function () {
    return view('visualizer');
});

Route::get('/sampler', function () {
    return view('sampler');
});

Route::get('/tapeloop-01', function () {
    return view('player/tapeloop-01');
});

Route::get('/johnhooks/rush', function () {
    return view('johnhooks/rush');
});

Route::get('/scottswenson/ne2', function () {
    return view('scottswenson/ne2');
});

Route::get('/scottswenson/it-flows-back', function () {
    return view('scottswenson/it-flows-back');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
