

<div class="row">
    <form action="<?= route('Contact') ?>" method="post" class="form">
        <h1>Envoyer un message</h1>
        <div>
            <input class="input" type="email" id="email" name="email" required autocomplete="off" placeholder="Entrez votre adresse e-mail">
        </div>
        <div>
            <textarea class="input" id="comment" name="comment" required autocomplete="off" placeholder="Entrez votre message"></textarea>
        </div>
        <div>
            <button type="submit">Envoyer</button>
        </div>
    </form>
</div>