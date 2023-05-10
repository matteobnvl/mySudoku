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
        <h2>Mes amis:</h2>
        <div class="box-amis">
            <?php if(!empty($amis)): ?>
                <?php foreach($amis as $ami): ?>
                    <div class="box">
                        <p><?= $ami->pseudo ?></p>
                        <p><?= ($ami->score === null) ? '0' : $ami->score ?> <i style="color:gold" class="fa-solid fa-trophy"></i></p>
                        <p>depuis <?= intervalleDate($ami->date) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun ami pour le moment</p>
            <?php endif; ?>
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
</script>