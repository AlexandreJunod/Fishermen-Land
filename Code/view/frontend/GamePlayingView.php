<?php $title = 'Fishermen Land'; ?>

<?php ob_start(); ?>
<form id='PlayerIsPlaying' method='post'> <!-- Select number of fishes to fish -->
    Poisson(s) à pêcher<br>
    <input type="text" name="NbFishing" minlength="1" value='0' required autofocus>
    <button type="submit" name="Fish">Pêcher</button>
</form>

<form method='post'> <!-- Pass the round -->
    <button type="submit" name="PassRound" value="<?= $ShowGameInfo['NextPlayer'] ?>">Passer mon tour</button>
</form>

<script>
function play()
{
    $( "#PlayerIsPlaying" ).submit(); //Send the form automatically after 15 seconds
}
setTimeout(play, 15000);
</script>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
