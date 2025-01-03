<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QueueController;
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
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/home', [UserController::class, 'home']);

Route::get('/viewQueue', function () {
    return view('queueView');
})->middleware('auth');

Route::get('/viewRecords', function () {
    return view('db');
})->middleware('auth');

Route::get('/userProfile', function () {
    return view('userProfile');
})->middleware('auth');

Route::get('/changePass', function () {
    return view('changePass');
})->middleware('auth');

//routes for user controls
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/userProfile', [UserController::class, 'updateProfile']);
Route::post('/changePass', [UserController::class, 'updatePass']);

// routes after registering
Route::view('/frontdesk', 'frontdesk')->name('frontdesk');
Route::view('/table', 'table')->name('table');

//For Queue related routes
Route::post('/enqueue', [QueueController::class, 'enqueue']);
Route::post('/dequeue', [QueueController::class, 'dequeue'])->name('dequeue');
Route::get('/viewRecords', [QueueController::class, 'showData']);
Route::get('/table', [QueueController::class, 'tellerDisplay'])->middleware('auth')->name('table');
Route::get('/viewQueue', [QueueController::class, 'displayView'])->name('queue.view');
Route::get('/getUpdatedQueueData', [QueueController::class, 'getUpdatedQueueData'])->name('queue.updated');
Route::get('/getUpdatedQueueInfo', [QueueController::class, 'getUpdatedQueueInfo'])->name('queue.info');
Route::get('/getTableData', [QueueController::class, 'getTableData']);



