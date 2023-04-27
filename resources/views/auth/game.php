<h1>page Game</h1>
<a href="<?= route(($_SESSION) ? 'Dashboard' : 'Accueil') ?>">
    <?= ($_SESSION) ? 'Retour dashboard' : 'Retour home' ?>
</a>
<table>
    <?php
    foreach(json_decode($sudoku[0]['tableau']) as $keyLignes => $lignes){
        ?>
        <tr>
            <?php foreach ($lignes as $keyCases => $cases) { ?>
                <td data-row="<?= $keyLignes.','.$keyCases ?>" <?= ($cases ==! 0) ? 'data-td='.$cases : '' ?>><?= ($cases ==! 0) ? $cases : '' ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>
<section>
    <div>1</div>
    <div>2</div>
    <div>3</div>
    <div>4</div>
    <div>5</div>
    <div>6</div>
    <div>7</div>
    <div>8</div>
    <div>9</div>
</section>

<script>

const elements = document.querySelectorAll('td')
const chiffres = document.querySelectorAll('div')
let selected = null

elements.forEach(function(item) {
    item.addEventListener('click', function(event) {
        elements.forEach(function(item) {
            item.classList.remove('selected')
        })
        item.classList.add('selected')
        selected = item
    })
})

chiffres.forEach(function(item) {
    item.addEventListener('click', function(event) {
        if (selected !== null && selected.textContent === '') {
            selected.textContent = item.textContent
        }
    })
})









</script>