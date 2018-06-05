<?php $title = 'Connexion'; ?>

<?php ob_start(); ?>
<div class="ContainerCenter">
    <div class="Title">Connexion</div>
    <div class="FormDesign">
        <div class="FormFields"><form method="post" id="FormLogin">
            Pseudo <input type="text" id="InputIndex" name="PseudoForm" minlength="5" maxlength="15" required autofocus> <br><br><br>
            Mot de passe <input type="password" id="InputIndex" name="PasswordForm" minlength="5" required></form></div>
        <div class="FormButton"><button type="submit" form="FormLogin" name="Login">Connexion</button></div>
    </div>
    <div class="FormLink"><a href="index.php?Signup">Pas encore de compte ? Inscrivez-vous !</a></div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
