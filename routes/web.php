<?php

use App\Http\Controllers\Admin\PageControl;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdControl;
use App\Livewire\Admin\ProfileControl;
use App\Livewire\Admin\UpdateControl;
use App\Livewire\Admin\Plugins\MediaDownloader;
use App\Http\Controllers\Install\Configuration;
use App\Http\Controllers\Install\Installer;
use App\Http\Controllers\HomeController;
use App\Livewire\Admin\LanguagesControl;
use App\Livewire\Admin\ThemeContent;
// use App\Livewire\Admin\Themes;
use App\Livewire\Admin\TranslateApiControl;
use App\Http\Controllers\FileTempController;
use App\Http\Controllers\Install\PreInstallController;

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

Route::get('/', [HomeController::class, 'index'])->middleware('geo')->name('home');

Route::get('/image', [FileTempController::class, 'Control'])->name('temporary.file');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'lang'])->name('dashboard');

Route::middleware(['auth', 'lang'])
->prefix('admin')
->name('admin.')
->group(function () {
    Route::get('ads', AdControl::class)->name('ads');
    Route::get('page', [PageControl::class, 'index'])->name('page');
    Route::get('profile', ProfileControl::class)->name('profile');
    Route::get('update', UpdateControl::class)->name('update');
    Route::get('translate-api', TranslateApiControl::class)->name('translate-api');
    Route::get('languages', LanguagesControl::class)->name('languages');
    // Route::get('themes', Themes::class)->name('themes');
    Route::get('template-content', ThemeContent::class)->name('template-content');

    Route::prefix('plugins')
    ->name('plugins.')
    ->group(function () {
        Route::get('media-downloader', MediaDownloader::class)->name('media_downloader');
    });

});

Route::middleware(['install'])->group(function () {
    Route::get('/configuration', [Configuration::class, 'index'])->name('page.configuration');
    Route::get('/installer', [Installer::class, 'index'])->name('page.installer');
    Route::get('/preinstall', [PreInstallController::class, 'index'])->name('preinstall');
});

require __DIR__ . '/auth.php';
