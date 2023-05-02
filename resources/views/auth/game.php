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
                <td 
                    data-row="<?= $keyLignes.','.$keyCases ?>" 
                    <?= ($cases ==! 0 && !strpos($cases, '*')) ? 'data-td='.$cases : 'style="color:blue"' ?>
                >
                    <?php if ($cases ==! 0 && !strpos($cases, '*')){echo $cases;} elseif (strpos($cases, '*')) {echo substr($cases, 0, -1);} else {echo '';} ?>
                </td>
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
    <div data-check="1"><i class="fa-solid fa-lightbulb"></i></div>
    <div data-verif="1"><i class="fa-solid fa-check"></i></div>
</section>

<script>

const elements = document.querySelectorAll('td')
const chiffres = document.querySelectorAll('div')
let selected = null
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
                selected.className = ''
                $.ajax({
                    url: '<?= env('APP_URL')?>/delete',
                    type: 'POST',
                    data: {attrCase: attrCase, id: <?= $_GET['sudoku'] ?>}
                })
            } else if ($(item).attr('data-check') != "1" && $(item).attr('data-verif') != "1") {
                selected.textContent = item.textContent
                selected.className = ''
                arrayCase = {key: attrCase , value: item.textContent}
                $.ajax({
                    url: '<?= env('APP_URL')?>/insert',
                    type: 'POST',
                    data: {arrayCase: arrayCase, id: <?= $_GET['sudoku'] ?>}
                })
            }
        }
    })
})

$('div[data-check]').click(function () {
    $.ajax({
        url: '<?= env('APP_URL')?>/verif',
        type: 'POST',
        data: {id: <?= $_GET['sudoku'] ?>},
        success: function (response) {
            response = JSON.parse(response)
            elements.forEach(function (item) {
                response.forEach(function (event) {
                    if ($(item).attr('data-row') == event.key) {
                        $(item).addClass((event.value)? 'true' : 'false')
                    }
                })
            })
        }
    })
})
</script>