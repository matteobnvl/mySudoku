<?php

namespace App\Models;

class Game extends Model
{
    public static function verifGame($id_partie, $id_joueur)
    {
        $db = self::db();
        $qry = "SELECT * FROM Partie
                WHERE :id_partie = :id_partie AND id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_partie' => $id_partie,
            ':id_joueur' => $id_joueur
        ]);
        return $stt->fetch(\PDO::FETCH_ASSOC) > 0;
    }

    public static function create($id_joueur = null)
    {
        $db = self::db();
        $qry = "INSERT INTO Partie (date_partie, id_statut, id_joueur, id_niveau)
                VALUES (:date_partie, :id_statut, :id_joueur, :id_niveau)";
        $stt = $db->prepare($qry);
        $date = new \DateTime();
        $date =$date->format('Y-m-d');
        $stt->execute([
            ':date_partie' => $date,
            ':id_statut' => 1,
            ':id_joueur' => $id_joueur,
            ':id_niveau' => 1
        ]);

        return true;
    }

    public static function getLastGameCreate($id_joueur = null)
    {
        $db = self::db();
        $qry = "SELECT id_partie FROM Partie
                WHERE id_joueur = :id_joueur OR id_joueur IS NULL
                ORDER BY id_partie DESC
                LIMIT 1";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $id_joueur
        ]);
        return $stt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function getGame($id_partie)
    {
        $db = self::db();
        $qry = "SELECT id_joueur
                FROM Partie
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_partie' => $id_partie
        ]);
        return $stt->fetch(\PDO::FETCH_ASSOC);
    }
}