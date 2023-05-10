<h1>Tous mes sudokus</h1>

<section id="content" class="contain-box-sudoku">
</section>

<script>

var offset = 0;

const statut = {
    1: 'En cours',
    2: 'Réussi',
    3: 'Perdu'
}

const niveau = {
    1: 'facile',
    2: 'moyen', 
    3: 'difficile',
    4: 'aléatoire'
}

$(document).ready(function() {
    var loading = false;
    loadMoreItems();
    $(window).on('load', function() {
        $(window).on('scroll', function() {
            const scrollPosition = $(window).scrollTop();
            const windowHeight = $(window).height();
            const documentHeight = $(document).height();
            if (scrollPosition + windowHeight >= documentHeight - 50 && !loading) {
                loading = true;
                loadMoreItems(function() {
                    loading = false;
                });
            }
        });
    });
});

function loadMoreItems(callback) {
    $.ajax({
        url: '<?= env('APP_URL') ?>/mes-sudokus',
        type: 'POST',
        dataType: "json",
        data: {offset: offset},
        success: function(data) {
            if(data.length > 0) {
                var html = '';
                $.each(data, function(index, element) {
                    tableau = JSON.parse(element.tableau)
                    var row = ""
                    for (var i = 0; i < tableau.length; i++) {
                        row += "<tr>"
                        for (var j = 0; j < tableau[i].length; j++) {
                            if (tableau[i][j] == 0) {
                                row += "<td>_</td>"
                            } else {
                                if (typeof tableau[i][j] == 'string') {
                                    row += "<td>" + tableau[i][j].slice(0, 1) + "</td>"
                                } else {
                                    row += "<td>" + tableau[i][j] + "</td>"
                                }
                            }
                        }
                        row += "</tr>"
                    }
                    console.log(row)
                    html = `<div class="box-sudoku">
                                <p>${element.date_partie}</p>
                                <div class="box">
                                    <div class="sudoku">
                                        <div class="table">
                                            <table>
                                                ${ row }
                                            </table>        
                                        </div>
                                    </div>
                                    <div class="statut">
                                        <div>
                                            <h2>Niveau ${ niveau[element.id_niveau] }</h2>
                                            <h3>Score : ${(element.score == null) ? '0' : element.score}</h3>
                                            <h3>Vie : ${element.vie}</h3>
                                        </div>
                                    </div>
                                    <div class="win">
                                        <div>${ statut[element.statut] }</div>
                                    </div>
                                </div>
                            </div>`;
                    $('#content').append(html);
                });
                offset += data.length;
                if (callback) {
                    callback();
                }
            }
        }
    });
}

</script>