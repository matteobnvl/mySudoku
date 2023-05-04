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
<div>
    <h2>Classement des joueurs</h2>
    <table>
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($scores as $score): ?>
                <tr>
                    <td><?= $score->pseudo ?></td>
                    <td><?= $score->score ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<div>
    <h2>Classement amis</h2>
    <table>
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($scores_amis as $score): ?>
                <tr>
                    <td><?= $score->pseudo ?></td>
                    <td><?= $score->score ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>