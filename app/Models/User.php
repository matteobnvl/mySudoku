<?php

namespace App\Models;

class User extends Model
{
    public static function login($email, $mdp) {

        $db = self::db();
        $qry = "SELECT * FROM Joueur
            WHERE email = :email AND mot_de_passe = :mdp";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':email' => htmlentities($email),
            ':mdp' => md5($mdp)
        ]);
        $user = $stt->fetch(\PDO::FETCH_ASSOC);

        if ($stt->rowCount() > 0) {

            foreach ($user as $key => $value) {
                $_SESSION[$key] = $value;
            }
            return true;
        }
        return false;
    }

    public static function checkMail($email)
    {
        $db = self::db();
        $qry = "SELECT * FROM Joueur WHERE email = :email";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':email' => $email
        ]);
        
        return $stt->fetch(\PDO::FETCH_ASSOC) > 0 ? false : true;
    }

    public static function register($post)
    {
        $db = self::db();
        $qry = "INSERT INTO Joueur (pseudo, email, mot_de_passe)
                VALUES (:pseudo, :email, :mdp)";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':pseudo' => htmlentities($post['pseudo']),
            ':email' => htmlentities($post['email']),
            ':mdp' => md5($post['password'])
        ]);
        return true;
    }
}