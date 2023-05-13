<div class="row">
    <form action="<?= route('Register') ?>" method="post" class="form">
    
        <h1>Créer un compte</h1>

        <div>
            <input class="input" type="text" id="pseudo" name="pseudo" required placeholder="pseudo">
        </div>
        <div>
            <input class="input" type="email" id="email" name="email" required placeholder="email">
        </div>
        <div>
            <input class="input" type="password" id="password" name="password" required autocomplete="off" placeholder="mot de passe">
        </div>
        <div>
            <input class="input" type="password" id="password-repeat" name="password-repeat" required autocomplete="off" placeholder="répéter mot de passe">
        </div>
        <div>
            <button id="btnRegister" disabled>M'inscrire</button>
        </div>
        
        <p><?= $error ==! '' ? $error : '' ?></p>
        
    </form>
</div>

<script>

    $('#password').on('input', function () {
        password = $(this).val()

        $('#password-repeat').on('input', function () {

            if (password == $(this).val()) {
                $('#btnRegister').removeAttr('disabled')
            } else {
                $('#btnRegister').attr('disabled', 'disabled')
            }
        })
    })
</script>