<?php $title = 'Inscription'; ?>

<?php ob_start(); ?>
<div class="ContainerCenter">
    <div class="Title">Inscription</div>
    <div class="FormDesign">
        <div class="FormFields"><form method="post" id="FormSignup">
            Pseudo <input type="text" name="PseudoForm" minlength="5" maxlength="15" required autofocus> <br><br><br>
            Mot de passe <input type="password" name="PasswordForm" minlength="5" required></form></div>
        <div class="FormButton"><button type="submit" form="FormSignup" name="Signup">Inscription</button></div>
    </div>
    <div class="FormLink"><a href="index.php">Déjà un compte ? Connectez-vous !</a></div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
