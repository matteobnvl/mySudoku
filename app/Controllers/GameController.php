<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Game;
use App\Models\Sudoku;
use App\Models\User;

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
            $statut = Game::getStatutVieByIdPartie($_GET['sudoku']);
            if (empty($sudoku)) {
                redirect('Dashboard');
            } 
        }
        return view('auth.game', [
            'sudoku' => $sudoku,
            'statut' => $statut[0]
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

            $score = Game::getVieById($id_partie);
            $score = $score[0]['vie'] -1;
            Game::updateScoreById($id_partie, $score);
            if ($score == 0) {
                Sudoku::updateStatutSudoku($id_partie, 3);
                return 'false';
            }
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
            return json_encode($arrayVerif);
        }
    }


    public function finish()
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
                        if (substr($case, 0, -1) != $solutionSudoku[$keyLigne][$keyCase]) {
                            $array = [
                                'key' => strval($keyLigne).','. strval($keyCase),
                                'value' => false
                            ];
                            $arrayVerif[] = $array;
                        }
                    }
                }
                
            }

            if (empty($arrayVerif)) {
                $score = Sudoku::getScoreByNiveau($id_partie);
                User::addScore($score[0]['score']);
                Sudoku::updateStatutSudoku($id_partie, 2);

                return json_encode(['key' => true, 'score' => $score[0]]);
            }
            return json_encode($arrayVerif);
        }
    }

    public function retry()
    {
        if ($_GET) {
            $id_partie = $_GET['sudoku'];

            Sudoku::updateStatutSudoku($id_partie, 1);
            Game::updateVieById($id_partie, 5);
            redirect('Game', '?sudoku='.$id_partie);
        }
    }
}