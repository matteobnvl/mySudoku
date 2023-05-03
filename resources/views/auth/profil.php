<h1>Page Profil</h1>
<a href="<?= route('Dashboard')?>">Dashboard</a>
<form action="<?= route('Profil') ?>" method="post">
    <label for="pseudo">pseudo</label>
    <input type="text" id="pseudo" name="pseudo" required autocomplete="off" value="<?= $_SESSION['pseudo'] ?>">

    <label for="email">email</label>
    <input type="email" id="email" name="email" required autocomplete="off" value="<?= $_SESSION['email'] ?>">

    <button>Modifier</button>
</form>

<div>
    <p>Score total : <?=  $_SESSION['score'] ?> </p>
</div>