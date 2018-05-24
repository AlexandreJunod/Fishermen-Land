<?php $title = 'Fishermen Land'; ?>

<?php ob_start(); ?>
<form method='post'> <!-- Select number of fishes to fish -->
    Poisson(s) à relâcher<br>
    <input type="text" name="NbReleasing" minlength="1" required autofocus>
    <?= "<button type='submit' name='Release' value=".$ShowGameInfo['NextPlayer']." >Relâcher</button>"?>
</form>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
