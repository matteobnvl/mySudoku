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
                json_encode($solutionSudoku), 
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

    public function insert()
    {
        if ($_POST) {
            $index = array_map('intval', explode(',', $_POST['arrayCase']['key']));
            $value = $_POST['arrayCase']['value'];
            $id_partie = $_POST['id'];
            $sudoku = Sudoku::getSudokuByPartie($id_partie);
            Sudoku::insert($index, $value, $sudoku, $id_partie);
        }
    }

    public function delete()
    {
        if ($_POST) {
            $index = array_map('intval', explode(',',$_POST['attrCase']));
            $id_partie = intval($_POST['id']);
            $sudoku = Sudoku::getSudokuByPartie($id_partie);
            Sudoku::delete($index, $sudoku, $id_partie);
        }
    }

    public function verif()
    {
        if ($_POST) {
            $id_partie = $_POST['id'];

            $solutionSudoku = Sudoku::getSolutionSudokuByPartie($id_partie);
            $solutionSudoku = json_decode($solutionSudoku[0]['solution']);

            $sudoku = Sudoku::getSudokuByPartie($id_partie);
            $sudoku = json_decode($sudoku[0]['tableau']);

            $arrayVerif = [];

            foreach ($sudoku as $keyLigne => $ligne) {
                foreach ($ligne as $keyCase => $case) {
                    if (strpos($case, '*')) {
                        $array = [
                            'key' => strval($keyLigne).','. strval($keyCase),
                            'value' => substr($case, 0, -1) == $solutionSudoku[$keyLigne][$keyCase]
                        ];
                        $arrayVerif[] = $array;
                    }
                }
                
            }
        }
        return json_encode($arrayVerif);
    }
}