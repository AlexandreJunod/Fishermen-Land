<?php $title = 'Fishermen Land'; ?>

<?php ob_start();
$Error = NULL; //Prevent to show multiple times the error
?>
<div class="PlayButtons">
    <form method='post'> <!-- Select number of fishes to fish -->
        Poisson(s) à relâcher<br>
        <input type="number" id='ValueSubmitRelease' name="NbReleasing" min="0" placeholder='0' required autofocus>
        <button type='submit' id='PlayerSubmitRelease' name='Release' value='<?= $ShowGameInfo['NextPlayer'] ?>'>Relâcher</button>
    </form>
</div>

<script>
function release()
{
    document.getElementById('ValueSubmitRelease').value = '0';
    document.getElementById('PlayerSubmitRelease').click(); //click automatically on the button after 15 seconds
}
setTimeout(release, 15000);
</script>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
