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
// $prefix = 'hello';
use MSA\LaravelGrapes\Http\Controllers\PageController;
Route::prefix(config('laravel-grapes.frontend_route_prefix'))->group(function(){
    Route::get('/', [PageController::class, 'index'])->name('website.builder');
    Route::post('/create-page', [PageController::class, 'store'])->name('new_page.store');
    Route::put('/update-page-content/{id}', [PageController::class, 'updateContent'])->name('update.page_content');
    Route::put('/update-page/{id}', [PageController::class, 'update'])->name('update.page');
    Route::get('/find-page/{id}', [PageController::class, 'show'])->name('page.find');
    Route::get('/all-pages', [PageController::class, 'allPages'])->name('page.all');
    Route::delete('/delete-page/{id}', [PageController::class, 'destroy'])->name('page.delete');
});

use MSA\LaravelGrapes\Http\Controllers\BlockController;
Route::get('get/custome-components', [BlockController::class, 'allBlocks'])->name('custome_component.all');
Route::post('/store/custome-component', [BlockController::class, 'store'])->name('custome_component.store');
Route::put('/store/custome-component/update/{id}', [BlockController::class, 'update'])->name('update.component');
Route::delete('/store/custome-component/delete/{id}', [BlockController::class, 'destroy'])->name('component.delete');

