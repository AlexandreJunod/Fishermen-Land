<?php $title = 'Fishermen Land'; ?>

<?php ob_start(); ?>
<form method='post'> <!-- Select number of fishes to fish -->
    Poisson(s) à pêcher<br>
    <input type="text" name="NbFishing" minlength="1" required autofocus>
    <button type="submit" name="Fish">Pêcher</button>
</form>

<form method='post'> <!-- Pass the round -->
    <button type="submit" name="PassRound" value="<?= $ShowGameInfo['NextPlayer'] ?>">Passer mon tour</button>
</form>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
