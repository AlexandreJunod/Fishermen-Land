<?php $title = 'Fishermen Land'; ?>

<?php ob_start();?>
<form method='post'> <!-- Select number of fishes to fish -->
    Poisson(s) à relâcher<br>
    <input type="number" name="NbReleasing" min="0" value='0' required autofocus>
    <button id='PlayerSubmitRelease' type='submit' name='Release' value='<?= $ShowGameInfo['NextPlayer'] ?>'>Relâcher</button>
</form>

<script>
function release()
{
    document.getElementById('PlayerSubmitRelease').click(); //click automatically on the button after 15 seconds
}
setTimeout(release, 15000);
</script>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
