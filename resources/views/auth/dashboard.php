<h1>Dashboard</h1>
<a href="<?= route('Game')?>">Jouer</a>
<a href="<?= route('Profil')?>">Profil</a>
<a href="<?= route('add_friends')?>">Ajouter amis <span>(<?= $demande_amis ?>)</span></a>
<a href="<?= route('Logout')?>">Déconnexion</a>
<br>
<hr>
<br>


<h2>Bonjour <?= $_SESSION['pseudo'] ?></h2>
<br>
<h3>Nouvelle partie : </h3>
<p>Choisissez votre niveau de difficulté :</p>
<form action="<?= route('Game')?>" method="POST">
    <select>
        <option value="easy">Facile</option>
        <option value="medium">Moyen</option>
        <option value="hard">Difficile</option>
    </select>
    <button type="submit">Jouer</button>
</form>
<br>
<h3>Mes sudokus</h3>
<br>
<ul>
    <?php foreach($sudokus as $sudoku) : ?>
        <li>
            sudoku n°<?= $sudoku['id_partie'] .' -  '. $sudoku['statut'].'  -  '. $sudoku['difficulte']?>  -  
            <a href="<?= route('Game')?>?sudoku=<?= $sudoku['id_partie']?>">
                <?= ($sudoku['statut'] === 1)? 'Reprendre' : 'Voir' ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
