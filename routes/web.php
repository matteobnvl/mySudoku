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

// Route Profil
Route::get(['/profil', 'App\Controllers\ProfilController@index'])->name('Profil');


// Route Game Sudoku
Route::get(['/insert', 'App\Controllers\GameController@insert'])->name('insert');
Route::get(['/delete', 'App\Controllers\GameController@delete'])->name('delete');
Route::get(['/verif', 'App\Controllers\GameController@verif'])->name('verif');
Route::get(['/finish', 'App\Controllers\GameController@finish'])->name('finish');
