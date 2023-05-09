<h1>Chercher une partie en multi</h1>

<a href="<?= route('multi')?>?mode=amis">Jouer contre un ami</a>
<a id="aleatoire" href="<?= route('multi')?>?mode=aleatoire">Aléatoire</a>

<div>
    <p id="p"><?= ($message !== '') ? $message :'' ?></p>
    <a href="<?= route('multi')?>?mode=annuler&id=<?= (isset($id_multi))? $id_multi : ''?>"><?= ($message !== '') ? 'annuler' :'' ?></a>
</div>

<script>
function checkForOpponent() {
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
$('#aleatoire').click(checkForOpponent())
</script>