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
            $email = $_POST['email'];
            $comment = $_POST['comment'];
    
            // envoyer le mail à l'admin
            $result = Mail::sendComment($email, $comment);

        }  

        //return view('pages.home', ['users' => $users]);
        return view('auth.contact');

    }

}