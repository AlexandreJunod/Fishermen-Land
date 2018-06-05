<?php ob_start(); ?>
    <div class="ContainerAdminView"><form method='post'><button type='submit' name='Settings'>Paramétrage du jeu</button></form></div>
<?php $content = ob_get_clean(); ?>

<?php $Error = NULL?> <!-- Don't let the error massage come 2 times when one admin is logged -->

<?php require('Template.php'); ?>
