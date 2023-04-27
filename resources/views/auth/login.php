<h1>Page Login</h1>
<form action="<?= route('Login')?>" method="post">
    <label for="email">email</label>
    <input type="email" id="email" name="email">

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password">
    <p><?= $error ==! '' ? $error : '' ?></p>
    <button>Me connecter</button>
</form>