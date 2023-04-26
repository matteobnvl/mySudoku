<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        if(!$_SESSION) {
            redirect('Accueil');
        }
    }

    public static function index()
    {
        return view('auth.dashboard');
    }
}