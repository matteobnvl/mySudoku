<h1 class="title-h1">Sudoku niveau <?= $niveau[$statut['id_niveau']] ?></h1>
<section id="toggleWin" class="toggle <?= ($statut['statut'] == 2 || $statut['statut'] == 3) ? 'active' : '' ?>">
    <p>
        <?= ($statut['statut'] == 2) ? 'Bravo tu as réussi ce sudoku !!' : '' ?>
        <?= ($statut['statut'] == 3) ? 'Tu n\'as pas réussis ce sudoku !' : '' ?>
        <span id="reussi"></span>
        <br><br>
        tu as obtenu <span id="score"><?= ($statut['statut'] == 2) ? $statut['score'] : '0' ?> points</span>
        <br><br>
        <a href="<?= route(($_SESSION) ? 'Dashboard' : 'Accueil') ?>">
            <?= ($_SESSION) ? 'Retour home' : 'Retour home' ?>
        </a>
    </p>
</section>
<section class="toggle" id="toggleVie">
    <p id="plusDeVie">
        Oh mince ! Vous n'avez plus de vie
    </p>
    <div>
        <a href="<?= route(($_SESSION) ? 'Dashboard' : 'Accueil')?>">Arreter la partie</a>
        <a href="<?= route('retry')?>?sudoku=<?= $_GET['sudoku']?>">Recommencer</a>
    </div> 
    
</section>
<section class="sudoku-gameplay">
    <p class="box-vie">Vos vies restantes : <span id="vie"></span> <i style="color:red" class="fa-solid fa-heart"></i></p>
    <table>
        <?php
        foreach(json_decode($sudoku[0]['tableau']) as $keyLignes => $lignes):
            ?>
            <tr>
                <?php foreach ($lignes as $keyCases => $cases) : ?>
                    <td 
                        data-row="<?= $keyLignes.','.$keyCases ?>" 
                        <?= ($cases ==! 0 && !strpos($cases, '*')) ? 'data-td='.$cases : 'style="color:blue"' ?>
                        <?= ($statut['statut'] == 2) ? 'data-finish="1"' : '' ?>
                    >
                        <?php if ($cases ==! 0 && !strpos($cases, '*')){echo $cases;} elseif (strpos($cases, '*')) {echo substr($cases, 0, -1);} else {echo '';} ?>
                    </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </table>
    <section class="choose-number">
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
        <div <?= ($statut['statut'] == 2 || $statut['statut'] == 3) ? '' : 'data-check="1"' ?>><i class="fa-solid fa-lightbulb"></i></div>
        <div <?= ($statut['statut'] == 2 || $statut['statut'] == 3) ? '' : 'data-verif="1"' ?>><i class="fa-solid fa-check"></i></div>
    </section>
</section>



<script>

const elements = document.querySelectorAll('td')
const chiffres = document.querySelectorAll('.choose-number div')
let selected = null
let arrayCase = {}

elements.forEach(function(item) {
    item.addEventListener('click', function(event) {
        if ($(item).attr('data-finish') != 1) {
            elements.forEach(function(item) {
                item.classList.remove('selected')
            })
            item.classList.add('selected')
            selected = item
            }
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
            if (response != 'false') {
                response = JSON.parse(response)
                vie = parseInt($('#vie').html())
                vie--
                $('#vie').html(vie.toString())
                elements.forEach(function (item) {
                    response.forEach(function (event) {
                        if ($(item).attr('data-row') == event.key) {
                            $(item).addClass((event.value)? 'true' : 'false')
                        }
                    })
                })
            } else {
                vie = parseInt($('#vie').html())
                vie--
                $('#vie').html(vie.toString())
                $('#toggleVie').addClass('active')
                elements.forEach(function (item) {
                        item.setAttribute('data-finish', '1')
                })
            }
        }
    })
})

$('div[data-verif]').click(function () {
    var finish = true
    elements.forEach(function (item) {
        if (item.textContent == 0) {
            finish = false
        }
    })
    if (finish) {
        $.ajax({
            url: '<?= env('APP_URL')?>/finish',
            type: 'POST',
            data: {id: <?= $_GET['sudoku'] ?>},
            success: function (response) {
                response = JSON.parse(response)
                if (response.key == true) {
                    elements.forEach(function (item) {
                        item.setAttribute('data-finish', '1')
                    })
                    $('#toggleWin').addClass('active')
                    $('#reussi').html('Bravo tu as réussi ce sudoku !!')
                    $('#score').html(response.score)
                } else {
                    elements.forEach(function (item) {
                        response.forEach(function (event) {
                            if ($(item).attr('data-row') == event.key) {
                                $(item).addClass((event.value)? 'true' : 'false')
                            }
                        })
                    })
                }
            }
        })
    }
})

$('#vie').html(<?= $statut['vie'] ?>)
</script>