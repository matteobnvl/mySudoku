<h2>Bonjour <?= $_SESSION['pseudo'] ?></h2>
<br>
<h3>Nouvelle partie : </h3>
<p>Choisissez votre niveau de difficulté :</p>
<form action="<?= route('Game')?>" method="POST">
    <select name="niveau">
        <option value="easy">Facile</option>
        <option value="medium">Moyen</option>
        <option value="hard">Difficile</option>
        <option value="random">Aléatoire</option>
    </select>
    <button type="submit">Jouer</button>
</form>
<br>
<h3>Mes sudokus</h3>
<br>
<ul>
    <?php foreach($sudokus as $sudoku) : ?>
        <li>
            sudoku n°<?= $sudoku['id_partie'] .' - '. $sudoku['statut'].'  -  '. $sudoku['difficulte']?>  -  
            <a href="<?= route('Game')?>?sudoku=<?= $sudoku['id_partie']?>">
                <?= ($sudoku['statut'] === 1)? 'Reprendre' : 'Voir' ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
