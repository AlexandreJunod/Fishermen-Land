<?php $title = 'Scores'; ?>

<?php ob_start();?>
<?= "<br>Score commun : $CommonScore<br>
Score collectif : $CollectiveScore<br>
Score individuel : $IndividualScore<br>"?>

<form method='post'> <!-- Leave the game or replay -->
    <?= "<button type='submit' name='ReplayGame'>Rejouer</button>"; ?>
    <?= "<button type='submit' id='ButtonLeaveGame' name='LeaveGame' value=".$idPlace.">Quitter la partie</button>"; ?>
</form>

<script>
function Leave()
{
    document.getElementById("ButtonLeaveGame").click(); //Click automatically after 15 seconds
}
setTimeout(Leave, 15000);
</script>

<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
