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
<div>
    <h2>Liste d'amis :</h2>
    <?php if(!empty($amis)): ?>
        <ul>
            <?php foreach($amis as $ami): ?>
            <li><?= $ami->pseudo ?></li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p>Aucun ami pour le moment</p>
    <?php endif; ?>
</div>