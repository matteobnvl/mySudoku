<div class="row">
    <form action="<?= route('Register') ?>" method="post" class="form">
    
        <h1>Créer un compte</h1>

        <div><input class="input" type="text" id="pseudo" name="pseudo" required autocomplete="off" placeholder="pseudo"></div>
        <div><input class="input" type="email" id="email" name="email" required autocomplete="off" placeholder="email"></div>
        <div><input class="input" type="password" id="password" name="password" required autocomplete="off" placeholder="mot de passe"></div>
        <div><button>M'inscrire</button></div>
        
        <p><?= $error ==! '' ? $error : '' ?></p>
        
    </form>
</div>