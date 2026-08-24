<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Five marketing pages, each a plain Blade view. Route names match the keys
| in config/site.php's nav array — the nav partial highlights the current
| page with request()->routeIs(), so adding a page means adding a route here
| and a label there, nothing else.
|
*/

Route::view('/', 'pages.home')->name('home');
Route::view('/services', 'pages.services')->name('services');
Route::get('/case-studies', [PageController::class, 'caseStudies'])->name('case-studies');
Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
Route::view('/contact', 'pages.contact')->name('contact');

Route::post('/leads', [LeadController::class, 'store'])
    ->middleware('throttle:leads')
    ->name('leads.store');
