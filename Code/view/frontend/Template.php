<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <?= @$Error; ?>
        <?= $content ?>
    </body>
</html>

<?php
if(isset($idPlace))
{
    $_SESSION['idPlace'] = $idPlace;
    $_SESSION['idGame'] = $idGame;
}
?>
