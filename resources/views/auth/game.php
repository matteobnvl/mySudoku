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
    <div data-del="1"><i class="fa-solid fa-eraser"></i></div>
</section>

<script>

const elements = document.querySelectorAll('td')
const chiffres = document.querySelectorAll('div')
let selected = null
let cases = []
let arrayCase = {}

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
        if (selected !== null && $(selected).attr('data-td') === undefined) {
            attrCase = $(selected).attr('data-row')
            if ($(item).attr('data-del') == "1") {
                selected.textContent = ''
                cases.forEach(function (item, index) {
                    if (attrCase === item.key) {
                        cases.splice(index, 1)
                    }
                    n++
                })
            } else {
                selected.textContent = item.textContent
                arrayCase = {key: attrCase , value: item.textContent}
                isInArray(arrayCase, cases)
                console.log(cases)
            }
            cases.push(arrayCase)
        }
    })
})

function isInArray(arrayCase, cases) {
    n = 0
    cases.forEach(function (item, index) {
        if (arrayCase.key === item.key) {
            cases.splice(index, 1)
        }
        n++
    })
}
</script>