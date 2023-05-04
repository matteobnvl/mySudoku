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

    public function index()
    {
        if (isset($_SESSION['difficulte'])) {
            $difficulte = $_SESSION['difficulte'];
        } else {
            $difficulte = 'easy';
        }
        $sudokus = Sudoku::getAllSudokuJoueur($_SESSION['id_joueur']);
        $demande_amis = User::countRequestFriends();

        return view('auth.dashboard',[
            'sudokus' => $sudokus,
            'demande_amis' => $demande_amis[0]['nbdemande']
        ]);
    }

    public function addFriends(){

        $message_valid = '';
        $listes_demandes_amis = User::getListRequestFriends();
        if (isset($_GET['id'])) {
            if (User::getCheckDemandeAmis($_GET['id'])) {
                User::addFriends($_GET['id']);
                $message_valid = ' amis ajouté';
            } else {
                $message_valid = 'déjà ajouté';
            }
            redirect('add_friends', '?message='.$message_valid);
        }
        return view('auth.add_friends',[
            'message_valid' => $message_valid,
            'liste_demande_amis' => $listes_demandes_amis
        ]);
    }

    public function search()
    {
        if ($_POST) {
            if ($_POST['data'] != '') {
                $users = User::searchUserByPseudo($_POST['data']);
                return json_encode($users);
            }
        }
    }

    public function accept()
    {
        if ($_GET) {
            User::acceptFriendsRequest($_GET['id']);
            $message_valid = 'demande d\'amis acceptée !';
            redirect('add_friends', '?message='.$message_valid);
        }
    }

    public function refuse()
    {
        if ($_GET) {
            User::deleteFriendsRequest($_GET['id']);
            $message_valid = 'demande d\'amis refusée !';
            redirect('add_friends', '?message='.$message_valid);
        }
    }
}