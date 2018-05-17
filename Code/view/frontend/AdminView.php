<?php ob_start(); ?>
    <form method='post'><button type='submit' name='Settings'>Paramétrage du jeu</button></form>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
