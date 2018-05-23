<?php

//Save the session when the Access was accepted after a login or a signup
function AccessAccepted($Pseudo)
{
    $_SESSION['Pseudo'] = $Pseudo;
    GoHome($Pseudo, NULL);
}

//Create the array $ShowPlayers and $ShowGameInfos
function DatasToShow($idGame)
{
    
}
