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

    public static function create($niveau = 1, $id_joueur = null)
    {
        $db = self::db();
        $qry = "INSERT INTO Partie (date_partie, statut, id_joueur, id_niveau)
                VALUES (:date_partie, :statut, :id_joueur, :id_niveau)";
        $stt = $db->prepare($qry);
        $date = new \DateTime();
        $date = $date->format('Y-m-d');
        $stt->execute([
            ':date_partie' => $date,
            ':statut' => 1,
            ':id_joueur' => $id_joueur,
            ':id_niveau' => $niveau
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
                WHERE id_partie = :id_partie AND id_niveau = :id_niveau";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_partie' => $id_partie,
            ':id_niveau' => 1
        ]);
        return $stt->fetch(\PDO::FETCH_ASSOC);
        
    }


    public static function getStatutVieByIdPartie($id_partie)
    {
        $db = self::db();
        $qry = "SELECT statut, vie
                FROM Partie
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_partie' => $id_partie
        ]);

        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getVieById($id_partie)
    {
        $db = self::db();
        $qry = "SELECT vie
                FROM Partie
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_partie' => $id_partie
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function updateScoreById($id, $vie)
    {
        $db = self::db();
        $qry = "UPDATE Partie
                SET vie = :vie
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':vie' => $vie,
            ':id_partie' => $id
        ]);
    }

    public static function updateVieById($id, $vie)
    {
        $db = self::db();
        $qry = "UPDATE Partie
                SET vie = :vie
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':vie' => $vie,
            ':id_partie' => $id
        ]);
    }

    public static function getIdNiveauByName($name)
    {
        $db = self::db();
        $qry = "SELECT id_niveau
                FROM Niveau
                WHERE difficulte = :name";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':name' => $name
        ]);

        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getStatutAndVieByIdPartie($id_partie)
    {
        $db = self::db();
        $qry = "SELECT statut, vie, id_niveau, score
                FROM Partie
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_partie' => $id_partie
        ]);

        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function addScore($score, $id_partie)
    {
        $db = self::db();
        $qry = "UPDATE Partie
                SET score = :score
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':score' => $score,
            ':id_partie' => $id_partie
        ]);
    }

    public static function getLastFiveSudokusByUser($id_joueur)
    {
        $db = self::db();
        $qry = "SELECT Partie.id_partie, Partie.statut, Partie.id_niveau, Sudoku.tableau
                FROM Partie
                INNER JOIN Sudoku ON Partie.id_partie = Sudoku.id_partie
                WHERE id_joueur = :id_joueur 
                        AND statut = :statut 
                        AND Sudoku.tableau IS NOT NULL 
                        AND Sudoku.tableau != 'null'
                ORDER BY Partie.id_partie DESC
                LIMIT 5";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $id_joueur,
            ':statut' => 1
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getGameByJoueurLimit($offset, $limit)
    {
        $db = self::db();
        $qry = "SELECT statut, Partie.id_niveau, tableau, date_partie, vie, score, Partie.id_partie
                FROM Partie
                INNER JOIN Sudoku ON Partie.id_partie = Sudoku.id_partie
                WHERE id_joueur = :id_joueur 
                        AND Sudoku.tableau IS NOT NULL
                        AND Sudoku.tableau != 'null'
                ORDER BY Partie.id_partie DESC
                LIMIT {$offset}, {$limit}";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $_SESSION['id_joueur']
        ]);

        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function countPartieByStatut($statut)
    {
        $db = self::db();
        $qry = "SELECT COUNT(id_partie) AS nbGame
                FROM Partie
                WHERE id_joueur = :id_joueur AND statut = :statut";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $_SESSION['id_joueur'],
            ':statut' => $statut
        ]);

        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }
}