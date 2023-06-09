<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\Mail;

class AuthentificationController extends Controller
{
    function __construct()
    {   
        
    }

    public function login()
    {
        if ($_SESSION) {
            redirect('Dashboard');
        }
        $forgotpassword = false;
        $mail = '';
        $checkMail = '';
        $message = '';
        if($_GET){
            if(isset($_GET['forgotpassword'])){
                $forgotpassword = true;
                if(isset($_GET['mail']) && $_POST) {
                    if($_POST['mail'] !== ''){
                        if(!Mail::checkMail($_POST)){
                            $mail = true;
                        } else {
                            if (User::verifAskResetPassword($_POST['mail'])) {
                                $mail = true;
                                $string = implode('', array_merge(range('A','Z'), range('a','z'), range('0','9')));
                                $token = substr(str_shuffle($string), 0, 30);
                                User::InsertTokenDate($_POST['mail'], $token);
                                $checkMail = Mail::ForgotPasswordMail($_POST, $token);
                            } else {
                                $mail = false;
                                $message = 'Une demande a déjà été formulée.<br> Consultez votre boite mail.';
                            }
                        }
                    }
                }
            }
        }
        $checker = $this->checkIfConnectionSent();
        $pages = 'login';
        return view('auth.login',[
            'pages' => $pages,
            'error' => $checker,
            'forgotpassword' => $forgotpassword,
            'mail' => $mail,
            'checkMail' => $checkMail,
            'message' => $message
        ]);
    }

    public function logout()
    {
        setcookie('remember_token', '', time() - 3600, '/');
        User::deleteCookie();
        session_destroy();
        redirect('Accueil');
    }

    public function register()
    {
        if ($_SESSION) {
            redirect('Dashboard');
        }
        $error = '';
        if ($_POST) {
            if ($_POST['email'] && $_POST['email'] ==! '' ||
                $_POST['pseudo'] && $_POST['pseudo'] ==! '' ||
                $_POST['password'] && $_POST['password'] ==! '') {
                    if (User::checkMailAndPseudo($_POST['email'], $_POST['pseudo'])) {
                        if (User::register($_POST)) {
                            User::login($_POST['email'], $_POST['password']);
                            redirect('Dashboard');
                        }

                    } else {
                        $error = "L'email ou le pseudo existe déjà";
                    }
                }
        }

        return view('auth.register', [
            'error' => $error
        ]);
    }

    public function ResetPassword() {
        if ($_GET && isset($_GET['token'])) {

            if ($_POST) {
                if (
                    $_POST['password'] !== '' &&
                    $_POST['password_reset'] !== '' &&
                    $_POST['password'] === $_POST['password_reset']
                ) {
                    $user = User::UserByToken($_GET['token']);
                    User::ResetPassword($_POST, $_GET['token']);
                    User::login($user[0]['email'], $_POST['password']);
                    redirect('Dashboard');
                }
            }


            if (User::VerifToken($_GET['token'])) {
                return view('auth.new_password', [
                    'pages' => 'dashboard'
                ]);
            }
        }
        redirect('Accueil');
    }

    private function checkIfConnectionSent() {

        if ($_POST) {
            if (isset($_POST['email']) && $_POST['email'] !== '') {
                if (isset($_POST['password']) && $_POST['password'] !== '') {
                    if (!User::login($_POST['email'], $_POST['password'])) {
                        return 'Les identifiants ne correspondent pas...';
                    } else {
                        if (!isset($_COOKIE['remember_token'])) {
                            $string = implode('', array_merge(range('A','Z'), range('a','z'), range('0','9')));
                            $token = substr(str_shuffle($string), 0, 50);;
                            User::insertToken($token);
                            $timestamp = time() + (30 * 24 * 60 * 60);
                            setcookie('remember_token', $token, $timestamp);;
                        }
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