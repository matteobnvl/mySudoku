<h1>Dashboard</h1>
<a href="<?= route('Game')?>">Jouer</a>
<a href="<?= route('Profil')?>">Profil</a>
<a href="<?= route('Logout')?>">Déconnexion</a>
<br>
<hr>
<br>


<h2>Bonjour <?= $_SESSION['pseudo'] ?></h2>
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

