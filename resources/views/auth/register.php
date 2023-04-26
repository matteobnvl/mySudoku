<h1>Page Inscription</h1>
<form action="<?= route('Register') ?>" method="post">
    <label for="mail">pseudo</label>
    <input type="text" id="pseudo" name="pseudo" required autocomplete="off">

    <label for="mail">email</label>
    <input type="email" id="email" name="email" required autocomplete="off">

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password" required autocomplete="off">
    <p><?= $error ==! '' ? $error : '' ?></p>
    <button>M'inscrire</button>
</form>