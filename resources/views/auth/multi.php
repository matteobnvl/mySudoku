<h1 class="title">Jouer contre un joueur aléatoirement</h1>
<section class="multi">
    <a id="aleatoire" href="<?= route('multi')?>?mode=aleatoire">chercher un joueur</a>
</section>
<div class="search-multi">
    <p id="p"><?= ($message !== '') ? $message :'' ?></p>
    <div>
        <a href="<?= route('multi')?>?mode=annuler&id=<?= (isset($id_multi))? $id_multi : ''?>"><?= ($message !== '') ? 'annuler' :'' ?></a>
    </div>
</div>

<script>
function checkForOpponent() {
    $('#loader').addClass('active')
    console.log('search player')
    $.ajax({
        url: '<?= env('APP_URL')?>/attente',
        type: 'POST',
        data: {id_multi: <?= (isset($id_multi))? $id_multi : ''?>},
        success: function(data) {
            if (data == 1) {
                window.location = '<?= env('APP_URL')?>/game-multi?duel=<?= $id_multi ?>'
            } else {
                setTimeout(checkForOpponent, 2000);
            }
        },
        error: function() {
            setTimeout(checkForOpponent, 2000);
        }
    });
}
$('#aleatoire').click(function () {
    $('#loader').addClass('active')
})
$('#aleatoire').click(checkForOpponent())
</script>