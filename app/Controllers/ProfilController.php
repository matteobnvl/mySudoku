<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Game;

class ProfilController extends Controller
{
    public function __construct()
    {
        if(!$_SESSION) {
            redirect('Accueil');
        }
    }

    public function index()
    {
        if ($_POST){
            if (isset($_POST['email']) && $_POST['email'] !== '' ||
                isset($_POST['pseudo']) && $_POST['pseudo'] !== '') {
                    User::update($_SESSION['id_joueur'] ,$_POST['pseudo'], $_POST['email']);
            }
        }
        $amis = User::getAmis($_SESSION['id_joueur']);

        $nbWin = Game::countPartieByStatut(2);
        $nbLose = Game::countPartieByStatut(3);
        $nbInProgress = Game::countPartieByStatut(1);
        
        return view('auth.profil', [
            'amis' => $amis,
            'nbWin' => $nbWin[0]['nbgame'],
            'nbLose' => $nbLose[0]['nbgame'],
            'nbInProgress' => $nbInProgress[0]['nbgame'],
        ]);
    }


}