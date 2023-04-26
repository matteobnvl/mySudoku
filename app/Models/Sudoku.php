<?php

namespace App\Models;

class Sudoku extends Model
{
    public static function generateSudoku($niveau = 'easy')
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://sugoku.onrender.com/board?difficulty='.$niveau);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public static function generateSolutionSudoku($data)
    {
        $curl_solution = curl_init();
        curl_setopt($curl_solution, CURLOPT_URL, "https://sugoku.onrender.com/solve");
        curl_setopt($curl_solution, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl_solution, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_solution, CURLOPT_CUSTOMREQUEST, "POST");
        $resultSolution = curl_exec($curl_solution);
        curl_close($curl_solution);
        return $resultSolution;
    }

    public static function createSudoku($tableau, $solution, $id_partie)
    {
        $db = self::db();
        $qry = "INSERT INTO Sudoku (tableau, solution, id_partie)
                VALUES (:tableau, :solution, :id_partie)";
        $stt = $db->prepare($qry);
        
        $stt->execute([
            ':tableau' => $tableau,
            ':solution' => $solution,
            ':id_partie' => $id_partie
        ]);
        return true;
    }

    public static function getSudokuByPartie($id_partie)
    {
        $db = self::db();
        $qry = "SELECT tableau FROM Sudoku
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_partie' => $id_partie
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getAllSudokuJoueur($id_joueur)
    {
        $db = self::db();
        $qry = "SELECT Partie.id_partie, Statut.type, Niveau.difficulte 
                FROM Partie
                INNER JOIN Statut ON Statut.id_statut = Partie.id_statut
                INNER JOIN Niveau ON Niveau.id_niveau = Partie.id_niveau
                WHERE id_joueur = :id_joueur";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':id_joueur' => $id_joueur
        ]);
        return $stt->fetchAll(\PDO::FETCH_ASSOC);
    }
}