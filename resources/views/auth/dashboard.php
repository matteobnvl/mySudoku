<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <h1>Dashboard</h1>
    <a href="<?= route('Profil')?>">Profil</a>
    <a href="<?= route('Logout')?>">Déconnexion</a>
    <br>
    <hr>
    <br>
    
    
    <h2>Bonjour <?= $_SESSION['pseudo'] ?></h2>
    <br>
    <h3>Nouvelle partie : </h3>
    <p>Choisissez votre niveau de difficulté :</p>
<!-------- En Cour
    <form action="<?= route('Game')?>" method="POST">
            <option value="easy">Facile</option>
            <option value="medium">Moyen</option>
            <option value="hard">Difficile</option>
        </select>
        <button type="submit">Jouer</button>
    </form>
--------->
    <br>
    <h3>Mes sudokus</h3>
    <br>
    <ul>
        <?php foreach($sudokus as $sudoku) { ?>
            <li>
                sudoku n°<?= $sudoku['id_partie'] .' -  '. $sudoku['type'].'  -  '. $sudoku['difficulte']?>  -  
                <a href="<?= route('Game')?>?sudoku=<?= $sudoku['id_partie']?>">
                    <?= ($sudoku['type'] === 'en cours')? 'Reprendre' : 'Voir' ?>
                </a>
            </li>
        <?php } ?>
    </ul>
   
</body>
</html>
