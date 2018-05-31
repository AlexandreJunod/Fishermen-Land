<?php $title = 'Connexion'; ?>

<?php ob_start(); ?>
    <h1>Connexion</h1>
        <form method="post" id="FormLogin">
            Pseudo <input type="text" id="InputIndex" name="PseudoForm" minlength="6" maxlength="13" required autofocus> <br><br><br>
            Mot de passe<input type="password" id="InputIndex" name="PasswordForm" minlength="6" required>
        </form> <br>
        <button type="submit" form="FormLogin" name="Login">Connexion</button>

    <a href="index.php?Signup">Pas encore de compte ? Inscrivez-vous !</a>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
