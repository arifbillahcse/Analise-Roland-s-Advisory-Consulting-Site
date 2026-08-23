<?php

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
Route::view('/case-studies', 'pages.case-studies')->name('case-studies');
Route::view('/testimonials', 'pages.testimonials')->name('testimonials');
Route::view('/contact', 'pages.contact')->name('contact');
