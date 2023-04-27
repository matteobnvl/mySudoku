<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;

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
        return view('auth.profil');
    }
}