
<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware(['auth', 'prevent-refresh'])->group(function () {
    Route::get('/exam', [App\Http\Controllers\ExamController::class, 'index']);
    Route::post('/exam/answer', [App\Http\Controllers\ExamController::class, 'answer']);
    Route::get('/exam/review', [App\Http\Controllers\ExamController::class, 'review']);
    Route::post('/exam/submit', [App\Http\Controllers\ExamController::class, 'submit']);
    Route::get('/exam/result', [App\Http\Controllers\ExamController::class, 'result']);
    Route::get('/thank-you', [App\Http\Controllers\ExamController::class, 'thankYou']);

});

