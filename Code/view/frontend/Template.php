<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet"/>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="public/js/jquery.js"></script>
    </head>
    <body>
        <?= @$Error; ?>
        <?php $Error = NULL //Prevebt to show error multiple times?>
        <?= $content ?>
    </body>
</html>

<?php
if(isset($idPlace))
{
    $_SESSION['idPlace'] = $idPlace;
}

if(isset($idGame))
{
    $_SESSION['idGame'] = $idGame;
}
?>
