<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChampionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RuneController;

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
Route::get('/',function(){
 return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::get('/champions', [ChampionController::class, 'fetchAndShowChampions']);
Route::get('/champions/show', [ChampionController::class, 'listChampions']);

Route::get('/sync-champions', [ChampionController::class, 'syncChampions']);
Route::get('/sync-items', [ItemController::class, 'syncItems'])->name('items.sync');
Route::get('/sync-runes', [RuneController::class, 'syncRunes'])->name('runes.sync');

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/create/{champion}', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/champion/{champion}', [PostController::class, 'indexByChampion'])->name('posts.byChampion');
Route::get('/posts/{champion}', [PostController::class, 'index'])->name('posts.index');
Route::get('/champions/{champion}/posts', [PostController::class, 'listByChampion'])->name('champions.posts');


require __DIR__.'/auth.php';
