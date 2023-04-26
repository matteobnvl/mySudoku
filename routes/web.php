<?php

use App\Route;

Route::get(['/', 'App\Controllers\HomeController@index'])->name('Accueil');

Route::get(['/login', 'App\Controllers\AuthentificationController@login'])->name('Login');

Route::get(['/logout', 'App\Controllers\AuthentificationController@logout'])->name('Logout');

Route::get(['/register', 'App\Controllers\AuthentificationController@register'])->name('Login');