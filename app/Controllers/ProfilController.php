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
        return view('auth.profil');
    }
}