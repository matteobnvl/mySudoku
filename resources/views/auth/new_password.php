<section class="contain-form">
    <form action="<?= route('ResetPassword')?>?token=<?= $_GET['token']?>" method="post">
        <div class="form-outline mb-4">
            <input type="password" name="password" id="password" class="form-control" />
            <label class="form-label" for="password">Mot de passe</label>
        </div>
        <div class="form-outline mb-4">
            <input type="password" name="password_reset" id="password_reset" class="form-control" />
            <label class="form-label" for="password_reset">Répéter mot de passe</label>
        </div>
        <button type="submit" class="btn btn-primary mb-4">Changer mot de passe</button>
    </form>
</section>