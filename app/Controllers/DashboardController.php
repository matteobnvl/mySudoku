<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Sudoku;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        if(!$_SESSION) {
            redirect('Login');
        }
    }

    public static function index()
    {
        $sudokus = Sudoku::getAllSudokuJoueur($_SESSION['id_joueur']);

        return view('auth.dashboard',[
            'sudokus' => $sudokus
        ]);
    }
}