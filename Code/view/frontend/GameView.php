<?php $title = 'Fishermen Land'; ?>

<?php ob_start(); ?>

<!-- Show players -->
<h3>Fishermen Land</h3>
<table border='1'>
    <tr>
        <td>Etang</td>
        <td>Poissons pêchés</td>
        <td>Poissons relachés</td>
        <td>Ordre de jeu</td>
        <td>Pseudo</td>
        <td>Classement</td>
        <td>Etat</td>
    </tr>
    <?php foreach($ShowPlayers as $ShowPlayer) //Reading each row of the table
    {
        echo "<tr>";
        foreach ($ShowPlayer as $key => $value)
        {
            echo "<td>".$value."</td>";
        }
    } ?>
</table>

<!-- Show infos of the game -->
<table border='1'>
    <tr>
        <td>Lac</td>
        <td>Reproduction dans le lac</td>
        <td>Reproduction dans le l'étang</td>
        <td>Nourriture nécessaire pour survire</td>
        <td>Premier joueur</td>
        <td>Tour</td>
        <td>Tours totaux</td>
        <td>Joueurs max</td>
        <td>Relâche max</td>
        <td>Type de partie</td>
        <td>Joueurs</td>
    </tr>
    <?php foreach($ShowGameInfos as $ShowGameInfo) //Reading each row of the table
    {
        echo "<tr>";
        foreach ($ShowGameInfo as $key => $value)
        {
            echo "<td>".$value."</td>";
        }
    } ?>
</table>

<form method='post'> <!-- Select number of fishes to fish -->
    Poisson(s) à pêcher<br>
    <input type="text" name="NbFishing" minlength="1" required autofocus>
    <button type="submit" name="Fish">Pêcher</button>
</form>

<form method='post'> <!-- Pass the round -->
    <button type="submit" name="PassRound">Passer mon tour</button>
</form>

<form method='post'> <!-- Leave the game -->
    <?= "<button type='submit' name='LeaveGame' value=".$idPlace.">Quitter la partie</button>"; ?>
</form>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
