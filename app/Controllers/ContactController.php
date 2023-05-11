<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Mail;

class ContactController extends Controller
{
    public function index()
    {
        if ($_POST) {
            // récupérer les données du formulaire
            $name = $_POST['name'];
            $email = $_POST['email'];
            $comment = $_POST['comment'];
    
            // envoyer le mail à l'admin
            $result = Mail::sendComment($name, $email, $comment);

            Mail::sendRemerciementContact($name, $email);


        }
        redirect('Accueil', '#contact?message='.$result);

    }

}