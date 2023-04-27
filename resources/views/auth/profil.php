<h1>Page Profil</h1>
<p>Pseudo : <?= $_SESSION['pseudo'] ?></p>
<p>Email : <?= $_SESSION['email'] ?></p>


<form action="<?= route('Profil') ?>" method="post">
    <label for="mail">pseudo</label>
    <input type="text" id="pseudo" name="pseudo" required autocomplete="off">

    <label for="email">email</label>
    <input type="email" id="email" name="email" required autocomplete="off">

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password" required autocomplete="off">
    <p><?= $error ==! '' ? $error : '' ?></p>
    <button>Modifier</button>
</form>