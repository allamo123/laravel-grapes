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
Route::get('/front-end-builder', [PageController::class, 'index'])->name('website.builder');
Route::post('/front-end-builder/create-page', [PageController::class, 'store'])->name('new_page.store');
Route::put('/front-end-builder/update-page-content/{id}', [PageController::class, 'updateContent'])->name('update.page_content');
Route::put('/front-end-builder/update-page/{id}', [PageController::class, 'update'])->name('update.page');
Route::get('/front-end-builder/find-page/{id}', [PageController::class, 'show'])->name('page.find');
Route::get('/front-end-builder/all-pages', [PageController::class, 'allPages'])->name('page.all');
Route::delete('/front-end-builder/delete-page/{id}', [PageController::class, 'destroy'])->name('page.delete');

use MSA\LaravelGrapes\Http\Controllers\BlockController;
Route::get('get/custome-components', [BlockController::class, 'allBlocks'])->name('custome_component.all');
Route::post('/store/custome-component', [BlockController::class, 'store'])->name('custome_component.store');
Route::put('/store/custome-component/update/{id}', [BlockController::class, 'update'])->name('update.component');
Route::delete('/store/custome-component/delete/{id}', [BlockController::class, 'destroy'])->name('component.delete');

Route::get('testing', function() {
    dd(config('lg.dynamic_traits_model.users'));
});
