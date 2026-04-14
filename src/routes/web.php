<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/recipe', [RecipeController::class, 'index'])->name('recipe.index');
    Route::post('/recipe/generate', [RecipeController::class, 'generate'])->name('recipe.generate');
    Route::post('/recipe/store', [RecipeController::class, 'store'])->name('recipe.store');
});
