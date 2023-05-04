<a href="<?= route('Dashboard')?>">retour dashboard</a>
<h1>Ajouter vos amis</h1>

<p style="color:green"><?= (isset($_GET['message'])) ? $_GET['message'] : '' ?></p>
<label for="searchFriends">Recherche le pseudo</label>
<input type="text" name="search" id="searchFriends">
<div id="listFriends"></div>

<h2>liste demande d'amis</h2>
<ul>
    <?php 
    if (!empty($liste_demande_amis)):
        foreach($liste_demande_amis as $amis) : ?>
        <li><?= $amis['pseudo']?>  <a href="<?= route('accept')?>?id=<?= $amis['id'] ?>">accepter</a>   <a href="<?= route('refuse')?>?id=<?= $amis['id'] ?>">refuser</a></li>
    <?php endforeach; else :
        echo 'Vous n\'avez aucune demande';
    endif ?>
</ul>


<script>
        function debounce(func, wait, immediate) {
        var timeout
        return function() {
            var context = this, args = arguments
            var later = function() {
                timeout = null
                if (!immediate) func.apply(context, args)
            }
            var callNow = immediate && !timeout
            clearTimeout(timeout)
            timeout = setTimeout(later, wait)
            if (callNow) func.apply(context, args)
        }
    }

    // définir la fonction de recherche
    function searchFriends() {
        $.ajax({
            url: '<?= env('APP_URL') ?>/search',
            type: 'POST',
            data: {data: $('#searchFriends').val()},
            success: function (response) {
                console.log(response)
                response = JSON.parse(response)
                console.log(response)
                response.forEach(function (item) {
                    $('#listFriends').append('<div>' + item.pseudo + ' <a href="<?= route('add_friends') ?>?id=' + item.id_joueur +'">ajouter</a></div>')
                })
            }
        })
    }

    $('#searchFriends').on('input', debounce(function() {
        $('#listFriends').empty()
        if ($(this).val().length > 3) {
            searchFriends()
        }
    }, 300))
</script>