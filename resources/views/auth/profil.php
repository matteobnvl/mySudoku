<h1>Mon profil  -  <?= $_SESSION['score']?><i style="color:gold" class="fa-solid fa-trophy"></i></h1>
<section class="section-update">
    <form action="<?= route('Profil') ?>" method="post">
        <div>
            <label for="pseudo">pseudo</label>
            <input type="text" id="pseudo" name="pseudo" required autocomplete="off" value="<?= $_SESSION['pseudo'] ?>">
        </div>
        <div>
            <label for="email">email</label>
            <input type="email" id="email" name="email" required autocomplete="off" value="<?= $_SESSION['email'] ?>">
        </div>
        <button><i class="fa-solid fa-floppy-disk"></i></button>
    </form>
</section>
<section class="section-profil">
    <div class="list-amis">
        <div class="box-btn">
            <button id="btn-amis">Mes Amis</button>
            <button id="btn-classement-mondial">Classement Mondial</button>
            <button id="btn-classement-amis">Classement Amis</button>
        </div>
        <div id="box-amis" class="box-amis active">
            <?php if(!empty($amis)): ?>
                <?php foreach($amis as $ami): ?>
                    <div class="box">
                        <table>
                        <tr>
                            <td><?= $ami->pseudo ?></td>
                            <td><?= ($ami->score === null) ? '0' : $ami->score ?> <i style="color:gold" class="fa-solid fa-trophy"></i></td>
                            <td>depuis <?= intervalleDate($ami->date) ?></td>
                        </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun ami pour le moment</p>
            <?php endif; ?>
        </div>
        <div id="classement-mondial" class="box-amis">
            <?php foreach($scores as $key => $score): ?>
                <div class="box classement-box">
                    <table>
                        <tr>
                            <td><?= (int) $key +1  ?><?= ($key == 0)? 'er' : 'ème' ?></td>
                            <td><?= $score->pseudo ?><?= ($score->pseudo == $_SESSION['pseudo']) ? ' <i class="fa-solid fa-star"></i>' :  '' ?></td>
                            <td><?= ($score->score === null) ? '0' : $score->score ?> <i style="color:gold" class="fa-solid fa-trophy"></i></td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="classement-amis" class="box-amis">
            <?php foreach($scores_amis as $key => $score): ?>
                <div class="box classement-box">
                    <table>
                        <tr>
                            <td><?= (int) $key +1  ?><?= ($key == 0)? 'er' : 'ème' ?></td>
                            <td><?= $score->pseudo ?><?= ($score->pseudo == $_SESSION['pseudo']) ? ' <i class="fa-solid fa-star"></i>':  '' ?></td>
                            <td><?= ($score->score === null) ? '0' : $score->score ?> <i style="color:gold" class="fa-solid fa-trophy"></i></td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>    
        </div>
    </div>
    <div id="chart">
        <h2>Mes stats :</h2>
    </div>
</section>

<script>
var options = {
        series: [<?= $nbWin ?>, <?= $nbLose ?>, <?= $nbInProgress ?>],
        chart: {
        width: 380,
        type: 'pie',
    },
    labels: ['gagné', 'perdu', 'en cours'],
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
            width: 200
            },
            legend: {
            position: 'bottom'
            }
        }
    }]
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

$('#btn-amis').click(function () {
    $('#classement-amis').removeClass('active')
    $('#classement-mondial').removeClass('active')
    $('#box-amis').addClass('active')
})

$('#btn-classement-amis').click(function () {
    $('#box-amis').removeClass('active')
    $('#classement-mondial').removeClass('active')
    $('#classement-amis').addClass('active')
})

$('#btn-classement-mondial').click(function () {
    $('#classement-amis').removeClass('active')
    $('#box-amis').removeClass('active')
    $('#classement-mondial').addClass('active')
})
</script>