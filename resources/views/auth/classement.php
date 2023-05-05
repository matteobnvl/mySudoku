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