<?php

use App\Route;

Route::get(['/', 'App\Controllers\HomeController@index'])->name('Accueil');

// Route Authentification

Route::get(['/login', 'App\Controllers\AuthentificationController@login'])->name('Login');
Route::get(['/logout', 'App\Controllers\AuthentificationController@logout'])->name('Logout');
Route::get(['/register', 'App\Controllers\AuthentificationController@register'])->name('Register');

// Route Dashboard
Route::get(['/dashboard', 'App\Controllers\DashboardController@index'])->name('Dashboard');

// Route Game 
Route::get(['/game', 'App\Controllers\GameController@index'])->name('Game');