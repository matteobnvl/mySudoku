<?php

use App\Route;

Route::get(['/', 'App\Controllers\HomeController@index'])->name('Accueil');

// Route Authentification

Route::get(['/login', 'App\Controllers\AuthentificationController@login'])->name('Login');
Route::get(['/logout', 'App\Controllers\AuthentificationController@logout'])->name('Logout');
Route::get(['/register', 'App\Controllers\AuthentificationController@register'])->name('Register');
Route::get(['/new-password', 'App\Controllers\AuthentificationController@ResetPassword'])->name('ResetPassword');


// Route Dashboard
Route::get(['/dashboard', 'App\Controllers\DashboardController@index'])->name('Dashboard');
Route::get(['/classement', 'App\Controllers\DashboardController@classement'])->name('classement');
Route::get(['/mes-sudokus', 'App\Controllers\DashboardController@allSudoku'])->name('all_sudoku');

// Route Game 
Route::get(['/game', 'App\Controllers\GameController@index'])->name('Game');

// Route Multijoueur
Route::get(['/multijoueur', 'App\Controllers\MultijoueurController@multi'])->name('multi');
Route::get(['/attente', 'App\Controllers\MultijoueurController@attente'])->name('attente');
Route::get(['/game-multi', 'App\Controllers\MultijoueurController@gameMulti'])->name('game_multi');
Route::get(['/sudoku-adverse', 'App\Controllers\MultijoueurController@sudokeAdverse'])->name('sudoku_adverse');
Route::get(['/insert-multi', 'App\Controllers\MultijoueurController@insertMulti'])->name('insert_multi');
Route::get(['/delete-multi', 'App\Controllers\MultijoueurController@deleteMulti'])->name('delete_multi');
Route::get(['/vie', 'App\Controllers\MultijoueurController@vie'])->name('vie_adverse');
Route::get(['/win', 'App\Controllers\MultijoueurController@win'])->name('win');
Route::get(['/lose', 'App\Controllers\MultijoueurController@lose'])->name('lose');
Route::get(['/check-vainqueur', 'App\Controllers\MultijoueurController@checkVainqueur'])->name('check_vainqueur');
Route::get(['/verif-multi', 'App\Controllers\MultijoueurController@verifMulti'])->name('verif_multi');
Route::get(['/finish-multi', 'App\Controllers\MultijoueurController@finishMulti'])->name('finish_multi');

// Route Profil
Route::get(['/profil', 'App\Controllers\ProfilController@index'])->name('Profil');


// Route Game Sudoku
Route::get(['/insert', 'App\Controllers\GameController@insert'])->name('insert');
Route::get(['/delete', 'App\Controllers\GameController@delete'])->name('delete');
Route::get(['/verif', 'App\Controllers\GameController@verif'])->name('verif');
Route::get(['/finish', 'App\Controllers\GameController@finish'])->name('finish');
Route::get(['/retry', 'App\Controllers\GameController@retry'])->name('retry');

//Route Amis
Route::get(['/ajouter-amis', 'App\Controllers\DashboardController@addFriends'])->name('add_friends');
Route::get(['/search', 'App\Controllers\DashboardController@search'])->name('search');
Route::get(['/accept', 'App\Controllers\DashboardController@accept'])->name('accept');
Route::get(['/refuse', 'App\Controllers\DashboardController@refuse'])->name('refuse');

