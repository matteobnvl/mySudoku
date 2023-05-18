<div class="row">
    <form action="<?= route('Login') ?>" method="post" class="form">
    
        <h1>Se connecter</h1>
        <div><input class="input" type="text" id="email" name="email" required autocomplete="off" placeholder="email ou pseudo"></div>
        <div><input class="input" type="password" id="password" name="password" required autocomplete="off" placeholder="mot de passe"></div>
        <div><button>Se connecter</button></div>
        <a href="<?= route('Login') ?>?forgotpassword=true">Mot de passe oublié ?</a>
        <p><?= ($error ==! '' && !isset($_GET['forgotpassword'])) ? $error : '' ?></p>
    </form>
</div>
<div id="toggle" class="toggle-contact <?php if($forgotpassword === true): ?>active<?php endif ?>">
    <i id="close" class="fa-solid fa-xmark"></i>
    <h3>Envoyer un mail de récupération</h3>
    <?php if($mail === false): ?>
        <p style="color:red"><?= $message ?></p>
    <?php endif ?>
    <?php if($mail !== true) { ?>
        <form action="<?= route('Login') ?>?forgotpassword=true&mail=true" method="post">
            <div style="width: 80%; margin:auto;" class="form-outline mb-4">
                <input type="email" name="mail" id="form4Example2" class="form-control" required />
                <label class="form-label" for="form4Example2">Votre Email</label>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Envoyer mail</button>
        </form>
    <?php }else{ ?>
        <p>Un mail vous a été envoyé si vous avez un compte, veuillez vérifier votre boite mail</p>
    <?php } ?>
</div>
<div id="toggle-page" class="toggle-page <?php if($forgotpassword === true): ?>active<?php endif ?>"></div>

<script>
const close = document.getElementById('close');

close.addEventListener('click', function(){
    document.getElementById('toggle').classList.remove('active');
    document.getElementById('toggle-page').classList.remove('active');
})
</script>