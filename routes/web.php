<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\FileUpload;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;

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

Route::controller(FileController::class)->group(function () {
    Route::get('/files/{id}', 'show')->name('files.show');
    Route::delete('/files/{id}', 'destroy')->name('files.destroy');
    Route::post('/files', 'store');
});

Route::controller(PostController::class)->group(function () {
    Route::get('/posts/create', 'create')->name('posts.create');
    Route::get('/posts/{id}/edit', 'edit')->name('posts.edit');
    Route::get('/posts/{id}', 'show')->name('posts.show');
    Route::delete('/post/{id}', 'destroy')->name('posts.destroy');
    Route::get('/posts', 'index')->name('posts');
    Route::post('/posts', 'store');
});

Route::get('/visualizer', function () {
    return view('visualizer');
});

Route::get('/visualizer/02', function () {
    return view('visualizer/visualizer-02');
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

Route::get('/dashboard', [Dashboard::class, 'show'])->middleware(['auth'])->name('dashboard');

Route::get('/{user:slug}/audio/{post:slug}', function (App\Models\User $user, App\Models\Post $post) {
    return view('post.show', ['post' => $post]);
});

require __DIR__ . '/auth.php';
