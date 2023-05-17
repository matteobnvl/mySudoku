<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Game;
use App\Models\Sudoku;
use App\Models\User;
use App\Models\Multijoueur;

class MultijoueurController extends Controller{

    function __construct()
    {
        if (!$_SESSION) {
            redirect('Accueil');
        }
    }

    public function multi()
    {
        $message = '';
        $id_multi = null;
        if ($_GET) {
            if ($_GET['mode'] === 'aleatoire') {
                if (!Multijoueur::checkUserHasNotDuel()) {
                    $message = 'recherche d\'un joueur';
                    $id_multi = Multijoueur::getIdMultiByJoueur();
                    $id_multi = $id_multi[0]['id_multi'];
                } else {
                    if (!Multijoueur::checkDuelInProgress()) {
                        $id_multi = Multijoueur::getIdDuelInProgress();
                        $id_multi = $id_multi[0]['id_multi'];
                        Multijoueur::createDuel($id_multi);
                        Multijoueur::updateComplet($id_multi);
                        redirect('game_multi', '?duel='.$id_multi);
                    } else {
                        // création du duel
                        $id_multi = Multijoueur::create();
                        Multijoueur::createDuel($id_multi);
                        $message = 'recherche d\'un joueur';
                    }
                }
            } else if ($_GET['mode'] === 'annuler') {
                Multijoueur::updateAnnuler($_GET['id']);
                redirect('multi');
            }
        }
        return view('auth.multi', [
            'message' => $message,
            'id_multi' => $id_multi
        ]);
    }

    public function attente()
    {
        if ($_POST) {
            $duel = Multijoueur::checkDuelIsComplete($_POST['id_multi']);
            $complet = ($duel[0]['complet'] == 1);
            return $complet;
        }
    }

    public function gameMulti()
    {
        if (!$_GET['duel']) {
            redirect('Dashboard');
        }
        if (!isset($_GET['sudoku'])) {
            $sudoku = Sudoku::generateSudoku();
            $id_sudoku = Sudoku::createSudoku(
                json_encode($sudoku->{'value'}),
                json_encode($sudoku->{'solution'}),
            );
            Multijoueur::updateSudokuDuel($id_sudoku, $_GET['duel']);
            redirect('game_multi', '?duel='.$_GET['duel'].'&sudoku='.$id_sudoku);
        }
        $sudokuJoueur = Sudoku::getTableauByIdSudoku($_GET['sudoku']);
        $statut = Multijoueur::getVieAndStatutByIdDuel($_GET['duel']);
        $adversaire = Multijoueur::getAdversaireDuelById($_GET['duel']);
        return view('auth.game_multi', [
            'adversaire' => $adversaire[0],
            'sudoku' => $sudokuJoueur[0],
            'statut' => $statut[0]
        ]);
    }

    public function sudokeAdverse()
    {
        if ($_POST) {
            $sudoku = Multijoueur::getSudokuAdverse($_POST['id']);
            $sudoku = $sudoku[0];
            return json_encode($sudoku['tableau']);
        }
    }

    public function insertMulti()
    {
        if ($_POST) {
            $index = array_map('intval', explode(',', $_POST['arrayCase']['key']));
            $value = $_POST['arrayCase']['value'];
            $id_sudoku = $_POST['id'];
            $sudoku = Sudoku::getSudokuById($id_sudoku);
            Sudoku::insertMulti($index, $value, $sudoku, $id_sudoku);
        }
    }

    public function deleteMulti()
    {
        if ($_POST) {
            $index = array_map('intval', explode(',',$_POST['attrCase']));
            $id_sudoku = intval($_POST['id']);
            $sudoku = Sudoku::getSudokuById($id_sudoku);
            Sudoku::deleteMulti($index, $sudoku, $id_sudoku);
        }
    }

    public function vie()
    {
        if ($_POST) {
            $vie = Multijoueur::getVieAdverseByIdMulti($_POST['id_duel']);
            return $vie[0]['vie'];
        }
    }

    public function checkVainqueur()
    {
        if ($_POST) {
            return Multijoueur::checkAdverseIsVainqueur($_POST['id_duel']);
        }
    }

    public function win()
    {
        if ($_POST) {
            $id_multi = $_POST['id_duel'];
            $id_sudoku = $_POST['id_sudoku'];
            $vie = Multijoueur::getVieAdverseByIdMulti($_POST['id_duel']);
            if ($vie[0]['vie'] == 0)
            {
                Multijoueur::UpdateJoueurVainqueurDuelById($id_multi);
                User::addScore(50);
                Multijoueur::updateScorePartie($id_multi);
                Multijoueur::updateStatutDuelById($id_multi, 2);
                redirect('game_multi', '?duel='.$id_multi.'&sudoku='.$id_sudoku);
            }
        }
    }

    public function lose()
    {
        if ($_POST) {
            $id_multi = $_POST['id_duel'];
            $id_sudoku = $_POST['id_sudoku'];
            if (Multijoueur::checkAdverseIsVainqueur($_POST['id_duel']) == 'true') {
                Multijoueur::updateStatutDuelById($id_multi, 3);
            }
        }
    }

    public function verifMulti()
    {
        if ($_POST) {
            $id_multi = $_POST['id_duel'];
            $id_sudoku = $_POST['id_sudoku'];

            $vie = Multijoueur::getVieAndStatutByIdDuel($id_multi);
            $vie = $vie[0]['vie'] -1;
            Multijoueur::updateVieById($id_multi, $vie);
            if ($vie == 0) {
                Multijoueur::updateStatutDuelById($id_multi, 3);
                return 'false';
            }
            $solutionSudoku = Sudoku::getSolutionSudokuByIdSudoku($id_sudoku);
            $solutionSudoku = json_decode($solutionSudoku[0]['solution']);

            $sudoku = Sudoku::getTableauByIdSudoku($id_sudoku);
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


    public function finishMulti()
    {
        if ($_POST) {
            $id_multi = $_POST['id_duel'];
            $id_sudoku = $_POST['id_sudoku'];

            $solutionSudoku = Sudoku::getSolutionSudokuByIdSudoku($id_sudoku);
            $solutionSudoku = json_decode($solutionSudoku[0]['solution']);

            $sudoku = Sudoku::getSudokuById($id_sudoku);
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
                Multijoueur::UpdateJoueurVainqueurDuelById($id_multi);
                User::addScore(50);
                Multijoueur::updateScorePartie($id_multi);
                Multijoueur::updateStatutDuelById($id_multi, 2);
                return json_encode(['key' => true, 'score' => 50]);
            }
            return json_encode($arrayVerif);
        }
    }
}