<?php

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

// New Frontend Routes
Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('front.index');
Route::get('/about', [App\Http\Controllers\FrontController::class, 'about'])->name('front.about');
Route::get('/contact', [App\Http\Controllers\FrontController::class, 'contact'])->name('front.contact');
Route::post('/contact', [App\Http\Controllers\FrontController::class, 'submitContact'])->name('front.contact.submit');
Route::get('/gallery', [App\Http\Controllers\FrontController::class, 'gallery'])->name('front.gallery');
Route::get('/films', [App\Http\Controllers\FrontController::class, 'films'])->name('front.films');
Route::get('/stories', [App\Http\Controllers\FrontController::class, 'stories'])->name('front.stories');
Route::get('/story/{slug}', [App\Http\Controllers\FrontController::class, 'storyDetail'])->name('front.story.detail');


Auth::routes();
Route::group(['middleware' => 'auth', 'prefix' => 'admin/', 'as' => 'admin.'], function () {
    // Story Categories and Stories
    Route::resource('story-categories', \App\Http\Controllers\Backend\StoryCategoriesController::class);
    Route::resource('stories', \App\Http\Controllers\Backend\StoriesController::class);
    
    // Gallery Categories and Galleries
    Route::resource('gallery-categories', \App\Http\Controllers\Backend\GalleryCategoriesController::class);
    Route::resource('galleries', \App\Http\Controllers\Backend\GalleriesController::class);
    
    // Film Categories and Films
    Route::resource('film-categories', \App\Http\Controllers\Backend\FilmCategoriesController::class);
    Route::resource('films', \App\Http\Controllers\Backend\FilmsController::class);
    
    // Keep only routes for tables we're maintaining
    Route::resource('product-categories', \App\Http\Controllers\Backend\ProductCategoriesController::class);
    Route::resource('products', \App\Http\Controllers\Backend\ProductsController::class);
    Route::resource('contact-messages', \App\Http\Controllers\Backend\ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::get('contact-messages/{id}/mark-read', [\App\Http\Controllers\Backend\ContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-read');
    Route::resource('custom-fields', \App\Http\Controllers\Backend\CustomFieldsController::class);
    Route::resource('site-settings', \App\Http\Controllers\Backend\SiteSettingsController::class);
    Route::resource('site-page-settings', \App\Http\Controllers\Backend\SitePagesController::class);
    
    // About Settings
    Route::get('about-settings', [\App\Http\Controllers\Backend\AboutSettingsController::class, 'index'])->name('about-settings.index');
    Route::put('about-settings', [\App\Http\Controllers\Backend\AboutSettingsController::class, 'update'])->name('about-settings.update');
    Route::post('about-settings/sections', [\App\Http\Controllers\Backend\AboutSettingsController::class, 'storeSection'])->name('about-settings.sections.store');
    Route::put('about-settings/sections/{id}', [\App\Http\Controllers\Backend\AboutSettingsController::class, 'updateSection'])->name('about-settings.sections.update');
    Route::delete('about-settings/sections/{id}', [\App\Http\Controllers\Backend\AboutSettingsController::class, 'destroySection'])->name('about-settings.sections.destroy');
    
    // Contact Settings
    Route::get('contact-settings', [\App\Http\Controllers\Backend\ContactSettingsController::class, 'index'])->name('contact-settings.index');
    Route::put('contact-settings', [\App\Http\Controllers\Backend\ContactSettingsController::class, 'update'])->name('contact-settings.update');
    
    // Homepage Settings
    Route::get('homepage-settings', [\App\Http\Controllers\Backend\HomepageSettingsController::class, 'index'])->name('homepage-settings.index');
    Route::put('homepage-settings', [\App\Http\Controllers\Backend\HomepageSettingsController::class, 'update'])->name('homepage-settings.update');
    Route::post('homepage-settings/sections', [\App\Http\Controllers\Backend\HomepageSettingsController::class, 'storeSection'])->name('homepage-settings.sections.store');
    Route::put('homepage-settings/sections/{id}', [\App\Http\Controllers\Backend\HomepageSettingsController::class, 'updateSection'])->name('homepage-settings.sections.update');
    Route::delete('homepage-settings/sections/{id}', [\App\Http\Controllers\Backend\HomepageSettingsController::class, 'destroySection'])->name('homepage-settings.sections.destroy');
    
    // Banners
    Route::resource('banners', \App\Http\Controllers\Backend\BannersController::class);
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('customer.profile');
    Route::post('/profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('customer.profile.update');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::get('/{slug}', [App\Http\Controllers\FrontController::class, 'pages'])->name('front.pages');

