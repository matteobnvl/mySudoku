


<div class="row">
    <form action="<?= route('Login') ?>" method="post" class="form">
    
        <h1>Se connecter</h1>

        <div><input class="input" type="email" id="email" name="email" required autocomplete="off" placeholder="email"></div>
        <div><input class="input" type="password" id="password" name="password" required autocomplete="off" placeholder="mot de passe"></div>
        <div><button>Se connecter</button></div>
        
        <p><?= $error ==! '' ? $error : '' ?></p>
        
    </form>
</div>