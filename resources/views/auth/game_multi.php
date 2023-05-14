<h1 class="title">Vous jouez contre <?= $adversaire['pseudo']?></h1>
<section id="toggleWin" class="toggle <?= ($statut['statut'] == 2 || $statut['statut'] == 3) ? 'active' : '' ?>">
    <p >
        <?= ($statut['statut'] == 2) ? 'Bravo tu as réussi ce sudoku !!' : '' ?>
        <?= ($statut['statut'] == 3) ? 'Tu n\'as pas réussis ce sudoku !' : '' ?>
        <span id="reussi"></span>
        <br><br>
            tu as obtenu <span id="score"><?= ($statut['statut'] == 2) ? $statut['score'] : '0' ?></span> points
        <br><br>
        <a href="<?= route('Dashboard') ?>">
            Retour
        </a>
    </p>
</section>
<section class="toggle" id="toggleVie">
    <p id="plusDeVie">
        Oh mince ! Vous n'avez plus de vies <br> Votre adversaire a gagné
    </p>
    <div>
        <a href="<?= route('Dashboard')?>">Retour</a>
    </div> 
    
</section>
<section class="sudoku-gameplay">
    <p class="box-vie">Vos vies restantes : <span id="vie"></span> <i style="color:red" class="fa-solid fa-heart"></i></p>
    <table>
        <?php
        foreach(json_decode($sudoku['tableau']) as $keyLignes => $lignes):
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
    <button class="btn-adversaire"><i class="fa-solid fa-eye"></i></button>
    <section class="adversaire">
        <p>vie adverse <span id="vieAdverse"></span></p>
        <div>
            <table id="sudokuAdverse"></table>
        </div>
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
                    url: '<?= env('APP_URL')?>/delete-multi',
                    type: 'POST',
                    data: {attrCase: attrCase, id: <?= $_GET['sudoku'] ?>}
                })
            } else if ($(item).attr('data-check') != "1" && $(item).attr('data-verif') != "1") {
                selected.textContent = item.textContent
                selected.className = ''
                arrayCase = {key: attrCase , value: item.textContent}
                $.ajax({
                    url: '<?= env('APP_URL')?>/insert-multi',
                    type: 'POST',
                    data: {arrayCase: arrayCase, id: <?= $_GET['sudoku'] ?>}
                })
            }
        }
    })
})

$('div[data-check]').click(function () {
    $.ajax({
        url: '<?= env('APP_URL')?>/verif-multi',
        type: 'POST',
        data: {id_duel: <?= $_GET['duel'] ?>, id_sudoku: <?= $_GET['sudoku'] ?>},
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
            url: '<?= env('APP_URL')?>/finish-multi',
            type: 'POST',
            data: {id_duel: <?= $_GET['duel'] ?>, id_sudoku: <?= $_GET['sudoku'] ?>},
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

$(document).ready(function() {
    function getSudoku () {
        $.ajax({
            url: '<?= env('APP_URL')?>/sudoku-adverse',
            type: 'POST',
            data: {id: <?= $adversaire['id_sudoku']?>},
            dataType: "json",
            success: function(data) {
                var sudoku = JSON.parse(data);
                $('#sudokuAdverse').empty()
                for (var i = 0; i < sudoku.length; i++) {
                    var row = "<tr>"
                    for (var j = 0; j < sudoku[i].length; j++) {
                        if (sudoku[i][j] == 0) {
                            row += "<td></td>"
                        } else {
                            if (typeof sudoku[i][j] == 'string') {
                                row += "<td>" + sudoku[i][j].slice(0, 1) + "</td>"
                            } else {
                                row += "<td>" + sudoku[i][j] + "</td>"
                            }
                        }
                    }
                    row += "</tr>"
                    $("#sudokuAdverse").append(row)
                }
            }
        })
    }

    function getVie () {
        $.ajax({
            url: '<?= env('APP_URL') ?>/vie',
            type: 'POST',
            data: {id_duel: <?= $_GET['duel']?>},
            success: function (data) {
                $('#vieAdverse').html(data)
                if (data == 0) {
                    joueurWin()
                }
            }
        })
    }

    function getVainqueur() {
        $.ajax({
            url: '<?= env('APP_URL')?>/check-vainqueur',
            type: 'POST',
            data: {id_duel: <?= $_GET['duel']?>},
            success: function (data) {
                if (data == 'true') {
                    joueurLose()
                }
            }
        })
    }

    function joueurWin() {
        $.ajax({
            url: '<?= env('APP_URL')?>/win',
            type: 'POST',
            data: {id_duel: <?= $_GET['duel']?>, id_sudoku: <?= $_GET['sudoku'] ?>},
            success: function () {
                $('#toggleWin').addClass('active')
                elements.forEach(function (item) {
                    item.setAttribute('data-finish', '1')
                })
                $('#reussi').html("Bravo tu as gagné le duel !")
                $('#score').html('50')
            }
        })
    }

    function joueurLose() {
        $.ajax({
            url: '<?= env('APP_URL')?>/lose',
            type: 'POST',
            data: {id_duel: <?= $_GET['duel']?>, id_sudoku: <?= $_GET['sudoku'] ?>},
            success: function () {
                elements.forEach(function (item) {
                    item.setAttribute('data-finish', '1')
                })
                $('#toggleWin').addClass('active')
                $('#reussi').html("Oh mince tu as perdu le duel !")
                $('#score').html('0')
            }
        })
    }
    getSudoku()
    getVie()
    getVainqueur()
    setInterval(getSudoku, 2000)
    setInterval(getVie, 2000)
    setInterval(getVainqueur, 2000)
})


$('.btn-adversaire').click(function () {
    $('.adversaire').toggle('active')
})
</script>