<?php

namespace App\Models;

class User extends Model
{
    public static function checkUser($email, $pwd) {

        $db = self::db();
        $qry = "SELECT * FROM Joueur
            WHERE email = :email AND mot_de_passe = :password";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':email' => $email,
            ':password' => md5($pwd)
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
}