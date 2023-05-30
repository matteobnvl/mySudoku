<?php

namespace App\Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


class Mail extends Model{

    public static function checkMail($post) {
        $db = self::db();
        $qry = "SELECT email
                FROM Joueur
                WHERE email = :email";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':email' => $post['mail']
        ]);
        if ($stt->rowCount() === 0){
            return false;
        }
        return true;
    }

    public static function ForgotPasswordMail($post, $token) {
        $mail = new PHPMailer();
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = env('HOST_MAIL');
            $mail->SMTPAuth = true;
            $mail->Username = env('USER_MAIL');
            $mail->Password = env('PASSWORD_MAIL');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = env('PORT_MAIL');
    
            //Recipients
            $mail->setFrom(env('EMAIL_SENT_FROM'));
            $mail->addAddress($post['mail']);     //Add a recipient
    
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Mot de passe oublié';
            $mail->Body = 'Pour votre nouveau mot de passe veuillez cliquer sur l\'adresse ci-dessous : <br><br>
                            . ' . $_ENV['APP_URL'] . '/new-password?token=' . $token . ' <br><br>
                            Si ce message ne vous est pas destiné, veuillez l\'ignorer.' ;
    
            $mail->send();
            return 'Le message à bien été envoyé !';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    public static function sendMailDemandeAmis($amis)
    {
        $mail = new PHPMailer();
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = env('HOST_MAIL');
            $mail->SMTPAuth = true;
            $mail->Username = env('USER_MAIL');
            $mail->Password = env('PASSWORD_MAIL');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = env('PORT_MAIL');
    
            //Recipients
            $mail->setFrom(env('EMAIL_SENT_FROM'));
            $mail->addAddress($amis['email']);     //Add a recipient
    
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Demande d\'amis !';
            $mail->Body = 'Hey '. $amis['pseudo'] .', Vous avez reçu une demande d\'amis de la part de '. $_SESSION['pseudo'].'.<br><br>
                            Pour l\'accepter cliquer ici sur ce lien : <br><br>' . $_ENV['APP_URL'] . '/ajouter-amis. <br><br>
                            Si ce message ne vous est pas destiné, veuillez l\'ignorer.' ;
    
            $mail->send();
            return 'Le message à bien été envoyé !';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public static function sendComment($name, $email, $comment)
    {
        $mail = new PHPMailer();
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contact_mysudoku@matteo-bonneval.fr';
            $mail->Password = '!Epsi2023Sudoku';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            //Recipients
            $mail->setFrom('contact_mysudoku@matteo-bonneval.fr');
            $mail->addAddress('matteobonneval19@gmail.com');     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Nouveau message';
            $mail->Body = 'Nouveau message depuis le site de la part de '. $name .'.<br><br>
                            Message : ' . $comment . ' <br><br>
                            Email : ' . $email . ' <br><br>';

            $mail->send();
            return 'Le messave nous a bien été envoyé. Merci pour votre soutien !';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    public static function sendRemerciementContact($name, $email)
    {
        $mail = new PHPMailer();
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contact_mysudoku@matteo-bonneval.fr';
            $mail->Password = '!Epsi2023Sudoku';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            //Recipients
            $mail->setFrom('contact_mysudoku@matteo-bonneval.fr');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Suite à votre contact';
            $mail->Body = 'Bonjour '. $name .', toute l\'équipe de MySudoku vous remercie pour votre message.<br><br>
                            Nous le traiterons dans les plus brefs délais, pour vous faire le meilleur retour possible.
                            En attendant vous pouvez compléter une grille de sudoku pour gagner encore plus de points !<br><br>
                            Bonne journée.<br><br>Cordialement,<br><br>L\'équipe MySudoku.';

            $mail->send();
            return 'Le commentaire a bien été envoyé !';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


}