
<div class="center-play">
    <img class="sudoku" src="public\images\sudoku.png" alt="">
    <a class="btn-play" href="<?= route('Game')?>">Jouer</a>
</div>

<section class="row-home">
    <div class="col">
        <h2>Bonjour à toi jeune joueur ! Bienvenue dans le monde du sudoku</h2>
        <div class="text1">
            <img class="lil-sudoku" src="public\images\sudoku_home.jpg" alt="">
            <div class="box-p">
                <p>
                    Tu peux jouer dès maintenant pour t'essayer à nos sudokus mais si tu souhaites sauvegarder ta progression ne
                    perds pas un instant à créer ton compte en cliquant<a href="<?= route('Register')?>"> ici</a>.
                </p>
            </div>
        </div>
        <div class="box-2">
            <h2 class="left">Avec ton comptes tu pourras...</h2>
            <div class="box">
                <p>
                    jouer à différents niveau pour obtenir des points
                </p>
                <img src="public/images/niveau.png" alt="image niveau">
            </div>
            <div class="box">
                <img src="public/images/amis.jpg" alt="image amis">
                <p>
                    ajouter tes amis pour voir leurs avancés
                </p>
            </div>
            <div class="box">
                <p>
                    te comparer aux autres joueurs pour devenir le meilleur
                </p>
                <img src="public/images/classement.jpg" alt="image classement">
            </div>
            <div class="box">
                <img src="public/images/stats.jpg" alt="image stats">
                <p>suivre ta progression d'un seul coup d'oeil</p>
            </div>
        </div>
        <h2 class="left">Les règles sont simples...</h2>
        <div class="box-img">
            <img src="public/images/pave_numerique.png" alt="image pavé numérique">
        </div>
        <h2 id="contact" class="left">Nous contacter...</h2>
        <p id="message"></p>
        <div class="box-contact">
            <form action="<?= route('Contact') ?>" method="post" class="form" id="form-contact">
                <div class="box">
                    <input type="text" name="name" id="name" required placeholder="Votre nom..">
                </div>
                <div class="box">
                    <input class="input" type="email" id="email" name="email" placeholder="Votre e-mail..">
                </div>
                <div class="box">
                    <textarea class="input" id="comment" name="comment" required autocomplete="off" placeholder="Votre message.."></textarea>
                </div>
                <div class="box">
                    <button type="submit"
                            class="g-recaptcha"
                            data-sitekey="<?= env('PUBLIC_KEY_CAPTCHA') ?>"
                            data-callback='onSubmit'
                            data-action='submit'>Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</section>
<footer>
    <p style="text-align: center;">
        Copyright © 2022 sudorivals.matteo-bonneval.fr - Tous droits réservés - développé par sudoweb
    </p>
</footer>

<script>
    if (window.location.hash === '#contact') {
        $('#message').html('Votre message a bien été envoyé !')
    }

    function onSubmit(token) {
        document.getElementById('form-contact').submit()
    }
</script>