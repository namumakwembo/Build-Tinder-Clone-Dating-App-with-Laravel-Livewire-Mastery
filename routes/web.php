<?php

use App\Livewire\Chat\Chat;
use App\Livewire\Chat\Index;
use App\Livewire\Home;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome');

Route::get('/app',Home::class)->middleware(['auth'])->name('app');
Route::get('/app/chat',Index::class)->middleware(['auth'])->name('chat.index');
Route::get('/app/chat/{chat}',Chat::class)->middleware(['auth'])->name('chat');

Route::post('/logout',function(){

    Auth::logout();

    return redirect('/');


})->name('logout');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
