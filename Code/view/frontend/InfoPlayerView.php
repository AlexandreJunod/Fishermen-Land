<?php ob_start();?>
<div class="ContainerInfoPlayer">
    <div class="RankContainer">
        <?php if($RankingPlayer == NULL)
        { ?>
            Non classé
        <?php }
        else
        {
            echo $RankingPlayer;
        }?>
    </div>
    <div class="PseudoContainer"><?= $Pseudo ?></div>
    <div class="ButtonContainer">
        <?php if($AllowDisconnect == 1)
        { ?>
            <form method="post">
                <button type="submit" name="DisconnectForm">Déconnexion</button>
            </form>
        <?php }
        else
        { ?>
            Non disponible
        <?php } ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
