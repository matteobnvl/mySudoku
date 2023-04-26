<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Game;
use App\Models\Sudoku;

class GameController extends Controller
{
    function __construct()
    {
        if ($_GET) {
            if ($_SESSION) {
                if (!Game::verifGame($_GET['sudoku'], $_SESSION['id_joueur'])) {
                    redirect('Dashboard');
                }
            } else {
                $partie = Game::getGame($_GET['sudoku']);
                if (empty($sudoku)) {
                    redirect('Accueil');
                } 
                if ($partie['id_joueur'] ==! null) {
                    redirect('Accueil');
                }
            }

        }
    }

    public function index()
    {

        if (!$_GET) {
            if ($_SESSION) {
                if (Game::create($_SESSION['id_joueur'])) {
                    $partie = Game::getLastGameCreate($_SESSION['id_joueur']);
                }
            } else {
                if (Game::create()) {
                    $partie = Game::getLastGameCreate();
                    
                }
            }
            $sudoku = Sudoku::generateSudoku();
            $solutionSudoku = json_decode(Sudoku::generateSolutionSudoku($sudoku));
            Sudoku::createSudoku(
                json_encode(json_decode($sudoku)->{'board'}), 
                json_encode($solutionSudoku->{'solution'}), 
                $partie['id_partie']);
            redirect('Game', '?sudoku='.$partie['id_partie']);
        } else {
            $sudoku = Sudoku::getSudokuByPartie($_GET['sudoku']);
            if (empty($sudoku)) {
                redirect('Dashboard');
            } 
        }
        return view('auth.game', [
            'sudoku' => $sudoku
        ]);
    }
}