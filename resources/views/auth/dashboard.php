<h2 class="title-dashboard">Bonjour <?= $_SESSION['pseudo'] ?> - <?= $_SESSION['score'] ?><i style="color:gold" class="fa-solid fa-trophy"></i></h2>
<section class="box-game">
    <form action="<?= route('Game')?>" method="POST">
        <select name="niveau" title="Selectionner un niveau">
            <option value="easy">Facile</option>
            <option value="medium">Moyen</option>
            <option value="hard">Difficile</option>
            <option value="random">Aléatoire</option>
        </select>
        <button title="lancer une nouvelle partie" type="submit">Jouer</button>
        <a href="<?= route('multi') ?>">Jouer en multi</a>
    </form>
</section>
<h3 class="title-h3">Mes derniers sudokus :</h3>
<section class="section-sudoku">
    <?php foreach($sudokus as $sudoku) : ?>
        <a href="<?= route('Game')?>?sudoku=<?= $sudoku['id_partie']?>" title="Reprendre le sudoku">
            <div class="box-sudoku">
            <h4>Sudoku niveau <?= $niveau[$sudoku['id_niveau']]?></h4>
            <table>
                <?php
                foreach(json_decode($sudoku['tableau']) as $keyLignes => $lignes):
                    ?>
                    <tr>
                        <?php foreach ($lignes as $keyCases => $cases) : ?>
                            <td>
                                <?php if ($cases ==! 0 && !strpos($cases, '*')){echo $cases;} elseif (strpos($cases, '*')) {echo substr($cases, 0, -1);} else {echo '';} ?>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </table>
            </div>
        </a>
    <?php endforeach ?>
    <a href="<?= route('all_sudoku') ?>" title="Tous mes sudokus">
        <div class="box">
            <i class="fa-solid fa-arrow-right"></i>
        </div>
    </a>
</section>
