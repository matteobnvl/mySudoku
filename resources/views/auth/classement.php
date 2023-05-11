<div class="classement-buttons">
    <h1>Classement</h1>
    <button class="active" data-target="#classement-mondial">Classement Mondial</button>
    <button data-target="#classement-amis">Classement Amis</button>
</div>

<div class="classement-container">
    <div id="classement-mondial" class="classement active">
        <table>
            <thead>
                <tr>
                    <th>rang</th>
                    <th>Pseudo</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores as $key => $score): ?>
                    <tr>
                        <td><?= (int) $key +1  ?></td>
                        <td><?= $score->pseudo ?></td>
                        <td><?= $score->score ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
    </div>

    <div id="classement-amis" class="classement">
        <table>
            <thead>
                <tr>
                    <th>position</th>
                    <th>Pseudo</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores_amis as $key => $score): ?>
                    <tr>
                        <td><?= (int) $key +1 ?></td>
                        <td><?= $score->pseudo ?></td>
                        <td><?= $score->score ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script>

    const mondialButton = document.querySelector('[data-target="#classement-mondial"]');
    const amisButton = document.querySelector('[data-target="#classement-amis"]');
    const mondialTable = document.querySelector('#classement-mondial');
    const amisTable = document.querySelector('#classement-amis');

    amisTable.style.display = 'none';

    mondialButton.addEventListener('click', function() {
        mondialTable.style.display = 'table';
        amisTable.style.display = 'none';
        mondialButton.classList.add('active');
        amisButton.classList.remove('active');
    });

    amisButton.addEventListener('click', function() {
        mondialTable.style.display = 'none';
        amisTable.style.display = 'table';
        amisButton.classList.add('active');
        mondialButton.classList.remove('active');
    });
</script>
