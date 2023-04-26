<h1>page Game</h1>
<a href="<?= route(($_SESSION) ? 'Dashboard' : 'Accueil') ?>">
    <?= ($_SESSION) ? 'Retour dashboard' : 'Retour home' ?>
</a>
<table>
    <?php
    foreach(json_decode($sudoku[0]['tableau']) as $lignes){
        ?>
        <tr>
            <?php foreach ($lignes as $cases) { ?>
                <td><?= ($cases ==! 0) ? $cases : '' ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>