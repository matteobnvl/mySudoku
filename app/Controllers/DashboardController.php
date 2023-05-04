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
        if (isset($_SESSION['difficulte'])) {
            $difficulte = $_SESSION['difficulte'];
        } else {
            $difficulte = 'easy';
        }
        $sudokus = Sudoku::getAllSudokuJoueur($_SESSION['id_joueur'], $difficulte);

        return view('auth.dashboard',[
            'sudokus' => $sudokus
        ]);
    }
}