<?php $title = 'Inscription'; ?>

<?php ob_start(); ?>
    <h1>Inscription</h1>

    <form method="post" id="FormSignup">
        Pseudo<input type="text" id="InputSignup" name="PseudoForm" minlength="6" maxlength="13" required autofocus> <br><br><br>
        Mot de passe<input type="password" id="InputSignup" name="PasswordForm" minlength="6" required>
    </form> <br>
    <button type="submit" form="FormSignup" name="Signup">Inscription</button>

    <a href="index.php">Déjà un compte ? Connectez-vous !</a>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
