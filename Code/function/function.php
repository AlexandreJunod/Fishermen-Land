<?php

//Save the session when the Access was accepted after a login or a signup
function AccessAccepted($Pseudo)
{
    $_SESSION['Pseudo'] = $Pseudo;
    GoHome($Pseudo);
}
