<?php

namespace App\Models;
use PDO;
use DateTime;

class User extends Model
{
    public static function login($email, $mdp) {

        $db = self::db();
        $qry = "SELECT * FROM Joueur
            WHERE email = :email AND mot_de_passe = :mdp";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':email' => htmlentities($email),
            ':mdp' => hash('sha256', $mdp)
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

    public static function checkMailAndPseudo($email, $pseudo)
    {
        $db = self::db();
        $qry = "SELECT * FROM Joueur WHERE email = :email OR pseudo = :pseudo";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':email' => $email,
            ':pseudo' => $pseudo
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
            ':mdp' => hash('sha256',$post['password'])
        ]);
        return true;
    }

    public static function update($id_joueur, $pseudo, $email)
    {
        $db = self::db();
        $qry = "UPDATE Joueur SET pseudo = :pseudo, email = :email  WHERE id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':pseudo' => htmlentities($pseudo),
            ':email' => htmlentities($email),
            ':id_joueur' => $id_joueur
        ]);
        $_SESSION['pseudo'] = htmlentities($pseudo);
        $_SESSION['email'] = htmlentities($email);
        return true;
    }

    public static function getAmis($id_joueur)
    {
        $db = self::db();
        $qry = "SELECT pseudo, score, Amis.date
                FROM Joueur 
                JOIN Amis ON (Joueur.id_joueur = Amis.id_amis OR Joueur.id_joueur = Amis.id_amis_1) 
                WHERE (Amis.id_amis = :id_joueur OR Amis.id_amis_1 = :id_joueur) 
                AND Joueur.id_joueur <> :id_joueur";
        $stt = $db->prepare($qry);
        $stt->bindParam(':id_joueur', $id_joueur, PDO::PARAM_INT);
        $stt->execute();
        $amis = $stt->fetchAll(PDO::FETCH_OBJ);
        return $amis;
    }

    public static function getScores()
    {
        $db = self::db();
        $qry = "SELECT pseudo, score FROM Joueur ORDER BY score DESC";
        $stt = $db->prepare($qry);
        $stt->execute();
        $scores = $stt->fetchAll(PDO::FETCH_OBJ);
        return $scores;
    }
    
    public static function addScore($score)
    {
        $newScore = $_SESSION['score'] + $score;
        $db = self::db();
        $qry = "UPDATE Joueur
                SET score = :score
                WHERE id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':score' => $newScore,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
        $_SESSION['score'] = $newScore;
    }

    public static function searchUserByPseudo($pseudo)
    {
        $db = self::db();
        $qry = "SELECT J.id_joueur, J.pseudo
                FROM Joueur AS J
                LEFT JOIN Amis AS A ON J.id_joueur = A.id_amis
                WHERE pseudo LIKE :pseudo 
                    AND pseudo != :pseudo_user";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':pseudo' => '%'.htmlentities($pseudo).'%',
            ':pseudo_user' => $_SESSION['pseudo']
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function addFriends($id_joueur)
    {
        $db = self::db();
        $qry = "INSERT INTO Amis
                (id_amis, id_amis_1, statut, `date`)
                VALUES (:id_amis, :id_amis_1, :statut, :date)";
        $stt = $db->prepare($qry);
        $stt = $db->prepare($qry);
        $date = new \DateTime();
        $date =$date->format('Y-m-d');
        $stt->execute([
            ':id_amis' => $_SESSION['id_joueur'],
            ':id_amis_1' => $id_joueur,
            ':statut' => 0,
            ':date' => $date
        ]);
    }

    public static function countRequestFriends()
    {
        $db = self::db();
        $qry = "SELECT COUNT(id) as nbDemande
                FROM Amis
                WHERE id_amis_1 = :id_joueur AND statut = :statut";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $_SESSION['id_joueur'],
            ':statut' => 0
        ]);

        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getListRequestFriends()
    {
        $db = self::db();
        $qry = "SELECT Amis.id, Joueur.id_joueur, Joueur.pseudo
                FROM Amis
                INNER JOIN Joueur ON Joueur.id_joueur = Amis.id_amis
                WHERE Amis.id_amis_1 = :id_joueur AND statut = :statut";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $_SESSION['id_joueur'],
            ':statut' => 0
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getCheckDemandeAmis($id)
    {
        $db = self::db();
        $qry = "SELECT *
                FROM Amis 
                WHERE id_amis = :id_joueur AND id_amis_1 = :id_demande";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $_SESSION['id_joueur'],
            ':id_demande' => $id
        ]);
        return empty($stt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public static function acceptFriendsRequest($id)
    {
        $db = self::db();
        $qry = "UPDATE Amis 
                SET statut = :statut 
                WHERE id = :id";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id' => $id,
            ':statut' => 1
        ]);
    }

    public static function deleteFriendsRequest($id)
    {
        $db = self::db();
        $qry = "DELETE FROM Amis
                WHERE id = :id";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id' => $id,
            ':statut' => 1
        ]);
    }

    public static function getScoresWithFriends()
    {
        $db = self::db();
        $qry = "SELECT j.pseudo, j.score 
                FROM Joueur j 
                LEFT JOIN Amis a ON (j.id_joueur = a.id_amis) 
                WHERE (a.id_amis = :id_joueur 
                    OR a.id_amis_1 = :id_joueur 
                    OR j.id_joueur = :id_joueur)
                ORDER BY score DESC";
        $stt = $db->prepare($qry);
        $stt->bindParam(':id_joueur', $_SESSION['id_joueur'], PDO::PARAM_INT);
        $stt->execute();
        $amis = $stt->fetchAll(PDO::FETCH_OBJ);
        return $amis;
    }


    public static function verifAskResetPassword($mail) {
        $db = self::db();
        $qry = "SELECT token_recovery_password
                FROM Joueur
                WHERE email = :email";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':email' => htmlentities($mail)
        ]);
        $token = $stt->fetchAll(\PDO::FETCH_ASSOC);
        if ($token[0]['token_recovery_password'] !== null) {
            $dateToken = self::checkDatePassword($mail);
            $dateDay = new DateTime();
            $dateDay = $dateDay->format('Y-m-d H:i:s');
            $dateToken = $dateToken[0]['date_recovery_password'];
            
            if (datediff($dateDay,$dateToken) < 5000) {
                return false;
            }
        }
        return true;
    }

    public static function checkDatePassword($mail) {
        $db = self::db();
        $qry = "SELECT date_recovery_password
                FROM Joueur
                WHERE email = :email";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':email' => $mail,
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function InsertTokenDate($mail, $token) {
        $db = self::db();
        $qry = "UPDATE Joueur
                SET token_recovery_password = :token_recovery_password, date_recovery_password = :date_recovery_password
                WHERE email = :email";
        $stt = $db->prepare($qry);
        $date = new \DateTime();
        $date =$date->format('Y-m-d-H-i-s');
        $stt->execute([
            ':token_recovery_password' => hash('sha256', $token),
            ':date_recovery_password' => $date,
            ':email' => $mail
        ]);
    }

    public static function UserByToken($token) {
        $db = self::db();
        $qry = "SELECT * 
                FROM Joueur
                WHERE token_recovery_password = :token";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':token' => hash('sha256', $token)
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function ResetPassword($post, $token) {
        $db = self::db();
        $qry = "UPDATE Joueur
                SET token_recovery_password = :token_recovery_password, 
                    date_recovery_password = :date_recovery_password, 
                    `mot_de_passe` = :pwd
                WHERE token_recovery_password = :token";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':token_recovery_password' => null,
            ':date_recovery_password' => null,
            ':pwd' => hash('sha256', $post['password']),
            ':token' => hash('sha256', $token)
        ]);
    }


    public static function VerifToken($token) {
        $db = self::db();
        $qry = "SELECT *
                FROM Joueur
                WHERE token_recovery_password = :token";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':token' => hash('sha256', $token)
        ]);
        $user = $stt->fetchAll(\PDO::FETCH_ASSOC);
        if($stt->rowCount() > 0) {
            $dateDay = new DateTime();
            $dateDay = $dateDay->format('Y-m-d H:i:s');
            $dateToken = $user[0]['date_recovery_password'];
            if (datediff($dateDay,$dateToken) < 5000) {
                return true;
            }
        }
        return false;
    }

    public static function getJoueur($id_joueur)
    {
        $db = self::db();
        $qry = "SELECT *
                FROM Joueur
                WHERE id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $id_joueur
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }
}