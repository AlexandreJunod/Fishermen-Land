<?php $title = 'Scores'; ?>

<?php ob_start();?>
<div class="ContainerEndGame">
    <div class="ScoreShow"><p align="left"><?= "<br>Score commun : $CommonScore<br>"; ?></p></div>
    <div class="ScoreShow"><p align="center"><?= "<br>Score collectif : $CollectiveScore<br>"; ?></p></div>
    <div class="ScoreShow"><p align="right"><?= "<br>Score individuel : $IndividualScore<br>"; ?></p></div>

    <form method='post'> <!-- Leave the game or replay -->
        <?= "<button type='submit' name='ReplayGame'>Rejouer</button>"; ?>
        <?= "<button type='submit' id='ButtonLeaveGame' name='LeaveGame' value=".$idPlace.">Quitter la partie</button>"; ?>
    </form>
</div>


<script>
function Leave()
{
    document.getElementById("ButtonLeaveGame").click(); //Click automatically after 15 seconds
}
setTimeout(Leave, 15000);
</script>

<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
