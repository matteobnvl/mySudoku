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

    public static function generateSolutionSudoku($grid)
    {
        $grid = self::solveSudoku(json_decode($grid)->{'board'});
        return json_encode($grid);
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

    public static function findEmpty($grid, &$row, &$col) {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                if ($grid[$row][$col] == 0) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public static function usedInRow($grid, $row, $num) {
        for ($col = 0; $col < 9; $col++) {
            if ($grid[$row][$col] == $num) {
                return true;
            }
        }
        return false;
    }
    
    public static function usedInCol($grid, $col, $num) {
        for ($row = 0; $row < 9; $row++) {
            if ($grid[$row][$col] == $num) {
                return true;
            }
        }
        return false;
    }
    
    public static function usedInBox($grid, $boxStartRow, $boxStartCol, $num) {
        for ($row = 0; $row < 3; $row++) {
            for ($col = 0; $col < 3; $col++) {
                if ($grid[$row + $boxStartRow][$col + $boxStartCol] == $num) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public static function isSafe($grid, $row, $col, $num) {
        return !self::usedInRow($grid, $row, $num) &&
               !self::usedInCol($grid, $col, $num) &&
               !self::usedInBox($grid, $row - ($row % 3), $col - ($col % 3), $num);
    }

    public static function findUnassignedLocation($grid) {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                if ($grid[$row][$col] === 0) {
                    return [$row, $col];
                }
            }
        }
        return null;
    }
    
    public static function solveSudoku(&$grid) {
        $row = 0;
        $col = 0;
    
        if (!self::findEmpty($grid, $row, $col)) {
            return $grid;
        }
    
        for ($num = 1; $num <= 9; $num++) {
            if (self::isSafe($grid, $row, $col, $num)) {
                $grid[$row][$col] = $num;
                if (self::solveSudoku($grid)) {
                    return $grid;
                }
                $grid[$row][$col] = 0;
            }
        }
    
        return false;
    }

    public static function insert($index, $value, $sudoku, $id_partie)
    {
        $sudoku = json_decode($sudoku[0]['tableau']);
        $sudoku[$index[0]][$index[1]] = $value.'*';
        $sudoku = json_encode($sudoku);

        $db = self::db();
        $qry = "UPDATE Sudoku
                SET tableau = :tableau
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':tableau' => $sudoku,
            ':id_partie' => $id_partie
        ]);
    }

    public static function delete($index, $sudoku, $id_partie)
    {
        $sudoku = json_decode($sudoku[0]['tableau']);
        $sudoku[$index[0]][$index[1]] = 0;
        $sudoku = json_encode($sudoku);

        $db = self::db();
        $qry = "UPDATE Sudoku
                SET tableau = :tableau
                WHERE id_partie = :id_partie";
        $stt = $db->prepare($qry);
        $stt->execute([
            ':tableau' => $sudoku,
            ':id_partie' => $id_partie
        ]);
    }
}