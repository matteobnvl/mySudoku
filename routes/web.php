<?php

use App\Route;

Route::get(['/', 'App\Controllers\HomeController@index'])->name('Accueil');

Route::get(['/login', 'App\Controllers\AuthentificationController@login'])->name('Login');

