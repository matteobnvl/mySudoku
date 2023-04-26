<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;

class AuthentificationController extends Controller
{
    public function login()
    {
        $error = $this->checkIfConnectionSent();
        return view('auth.login', compact('error'));
    }

    public function logout()
    {
        session_destroy();
        redirect('Accueil');
    }

    public function register()
    {
        $error = '';
        if ($_POST) {
            if ($_POST['email'] && $_POST['email'] ==! '' ||
                $_POST['pseudo'] && $_POST['pseudo'] ==! '' ||
                $_POST['password'] && $_POST['password'] ==! '') {
                    if (User::checkMail($_POST['email'])) {
                        if (User::register($_POST)) {
                            User::login($_POST['email'], $_POST['password']);
                            redirect('Dashboard');
                        }

                    } else {
                        $error = "L'email renseigné existe déjà";
                    }
                }
        }

        return view('auth.register', [
            'error' => $error
        ]);
    }

    private function checkIfConnectionSent() {

        if ($_POST) {
            if (isset($_POST['email']) && $_POST['email'] !== '') {
                if (isset($_POST['password']) && $_POST['password'] !== '') {
                    if (!User::login($_POST['email'], $_POST['password'])) {
                        return 'Les identifiants ne correspondent pas...';
                    } else {
                        redirect('Dashboard');
                    }
                } else {
                    return "Le mot de passe doit être renseigné";
                }
            } else {
                return "L'email doit être renseigné";
            }
        }
    }
}