<?php

namespace App\Models;

class Multijoueur extends Model{

    public static function checkUserHasDuel()
    {
        $db = self::db();
        $qry = "SELECT *
                FROM Multijoueur
                LEFT JOIN Duel ON Multijoueur.id_multi = Duel.id_multi
                WHERE Duel.id_joueur = :id_joueur AND Multijoueur.complet = :complet";
        $stt = $db->prepare($qry);
        $stt-> execute([
            ':id_joueur' => $_SESSION['id_joueur'],
            ':complet' => 0
        ]);

        $duel = $stt->fetchAll(\PDO::FETCH_ASSOC);

        return (empty($duel)) ? true : false;
    }

    public static function checkDuelInProgress()
    {
        $db = self::db();
        $qry = "SELECT Multijoueur.id_multi
                FROM Multijoueur
                LEFT JOIN Duel ON Multijoueur.id_multi = Duel.id_multi
                WHERE complet = :complet AND termine = :termine AND Duel.id_joueur != :id_joueur
                LIMIT 1";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':complet' => 0,
            ':termine' => 0,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
        $duel = $stt->fetchAll(\PDO::FETCH_ASSOC);
        return (empty($duel)) ? true : false;
    }

    public static function create()
    {
        $db = self::db();
        $qry = "INSERT INTO Multijoueur
                (date_start, complet, termine)
                VALUES (:date_start, :complet, :termine)";
        $stt = $db->prepare($qry);
        $date = date('Y-m-d H:i:s');
        $stt->execute([
            ':date_start' => $date,
            ':complet' => 0,
            ':termine' => 0
        ]);

        return $db->lastInsertId();
    }


    public static function createDuel($id_multi)
    {
        $db = self::db();
        $qry = "INSERT INTO Duel
                (id_joueur, id_multi)
                VALUES (:id_joueur, :id_multi)";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $_SESSION['id_joueur'],
            ':id_multi' => $id_multi
        ]);
    }

    public static function updateAnnuler($id_multi)
    {
        $db = self::db();
        $qry = "UPDATE Multijoueur
                SET complet = :complet
                WHERE id_multi = :id_multi";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':complet' => 1,
            ':id_multi' => $id_multi
        ]);
    }

    public static function getIdMultiByJoueur()
    {
        $db = self::db();
        $qry = "SELECT Multijoueur.id_multi
                FROM Multijoueur
                LEFT JOIN Duel ON Multijoueur.id_multi = Duel.id_multi
                WHERE Duel.id_joueur = :id_joueur AND Multijoueur.complet = :complet";
        $stt = $db->prepare($qry);
        $stt-> execute([
            ':id_joueur' => $_SESSION['id_joueur'],
            ':complet' => 0
        ]);

        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function updateComplet($id_multi)
    {
        $db = self::db();
        $qry = "UPDATE Multijoueur
                SET complet = :complet
                WHERE id_multi = :id_multi";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':complet' => 1,
            ':id_multi' => $id_multi
        ]);
    }

    public static function getIdDuelInProgress()
    {
        $db = self::db();
        $qry = "SELECT Multijoueur.id_multi
                FROM Multijoueur
                LEFT JOIN Duel ON Multijoueur.id_multi = Duel.id_multi
                WHERE complet = :complet AND termine = :termine AND Duel.id_joueur != :id_joueur
                LIMIT 1";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':complet' => 0,
            ':termine' => 0,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function checkDuelIsComplete($id_multi)
    {
        $db = self::db();
        $qry = "SELECT *
                FROM Multijoueur
                WHERE id_multi = :id_multi";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_multi' => $id_multi
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function getAdversaireDuelById($id_multi)
    {
        $db = self::db();
        $qry = "SELECT Joueur.pseudo, Duel.vie, Duel.id_sudoku
                FROM Duel
                INNER JOIN Joueur ON Joueur.id_joueur = Duel.id_joueur
                WHERE id_multi = :id_multi AND Duel.id_joueur != :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_multi' => $id_multi,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function updateSudokuDuel($id_sudoku, $id_multi)
    {
        $db = self::db();
        $qry = "UPDATE Duel
                SET id_sudoku = :id_sudoku
                WHERE id_multi = :id_multi AND id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_sudoku' => $id_sudoku,
            ':id_multi' => $id_multi,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
    }

    public static function getVieAndStatutByIdDuel($id_multi)
    {
        $db = self::db();
        $qry = "SELECT vie, statut, score
                FROM Duel
                WHERE id_multi = :id_multi AND id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_multi' => (int) $id_multi,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getSudokuAdverse($id_sudoku)
    {
        $db = self::db();
        $qry = "SELECT tableau
                FROM Sudoku
                WHERE id_sudoku = :id_sudoku";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_sudoku' => $id_sudoku
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getVieAdverseByIdMulti($id_multi)
    {
        $db = self::db();
        $qry = "SELECT vie
                FROM Duel
                WHERE id_multi = :id_multi AND id_joueur != :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_multi' => $id_multi,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function checkAdverseIsVainqueur($id_multi)
    {
        $db = self::db();
        $qry = "SELECT vainqueur
                FROM Duel
                WHERE id_multi = :id_multi AND id_joueur != :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_multi' => $id_multi,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
        $vainqueur = $stt->fetchAll(\PDO::FETCH_ASSOC);
        return ($vainqueur[0]['vainqueur'] == 1) ? 'true' : 'false';
    }

    public static function updateVieById($id_multi, $vie)
    {
        $db = self::db();
        $qry = "UPDATE Duel
                SET vie = :vie
                WHERE id_multi = :id_multi AND id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':vie' => $vie,
            ':id_multi' => $id_multi,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
    }

    public static function updateStatutDuelById($id_multi, $statut)
    {
        $db = self::db();
        $qry = "UPDATE Duel
                SET statut = :statut
                WHERE id_multi = :id_multi AND id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':statut' => $statut,
            ':id_multi' => $id_multi,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
    }

    public static function UpdateJoueurVainqueurDuelById($id_multi)
    {
        $db = self::db();
        $qry = "UPDATE Duel
                SET vainqueur = :vainqueur
                WHERE id_multi = :id_multi AND id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':vainqueur' => 1,
            ':id_multi' => $id_multi,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
    }

    public static function updateScorePartie($id_multi)
    {
        $db = self::db();
        $qry = "UPDATE Duel
                SET score = :score
                WHERE id_multi = :id_multi AND id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':score' => 50,
            ':id_multi' => $id_multi,
            ':id_joueur' => $_SESSION['id_joueur']
        ]);
    }
}