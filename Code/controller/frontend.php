<?php

require('model/frontend.php');

if(isset($Pseudo))
{
    $Pseudo = $_SESSION['Pseudo'];
}

//Login the user if his pseudo and password correspond with the database
function DoLogin($Pseudo, $Password)
{
    //Check if the Form was sent
    if(isset($Pseudo) && isset($Password))
    {
        $InfoLogins = Login($Pseudo, $Password); //Check if the account exists

        if($InfoLogins != NULL) //If datas are returned, the pseudo exists
        {
            extract($InfoLogins); //$idPlayer, $PseudoPlayer, $PasswordPlayer, $HashPassword

            if($PasswordPlayer == $HashPassword) //Check if the password gived by the user is the same than the password hashed of the data base
            {
                AccessAccepted($Pseudo);
                return;
            }
            else
            {
                $Error = "Le mot de passe est erroné";
                unset($_SESSION['Pseudo']); //Dont let the session start
                unset($Pseudo); //Dont let the session start
            }
        }
        else //No datas were returned, the pseudo was not find
        {
            $Error = "Le pseudo est erroné";
            unset($_SESSION['Pseudo']); //Dont let the session start
            unset($Pseudo); //Dont let the session start
        }
    }
    require('view/frontend/LoginView.php');
}

//Create the user if this one doesn't exist yet
function DoSignup($Pseudo, $Password)
{
    //Check if the Form was sent
    if(isset($Pseudo) && isset($Password))
    {
        $InfosSignup = CheckAccount($Pseudo); //Check if the account exists

        if($InfosSignup->rowCount() > 0) //Check if the user is already on the database
        {
            $Error = "Ce pseudo existe déjà"; //Varriable to show the error message
            unset($_SESSION['Pseudo']); //Dont let the session start
            unset($Pseudo); //Dont let the session start;
        }
        else //Create the account and save the session
        {
            Signup($Pseudo, $Password); //Create the account
            AccessAccepted($Pseudo);
            return;
        }
    }
    require('view/frontend/SignupView.php');
}

//List the games
function GoHome($Pseudo, $Error)
{
    $ListGames = GetListGames(); //Take the datas of the database

    $ShowGames = array(); //Create the array for informations about the games
    foreach($ListGames as $ListGame)
    {
        if($ListGame['TourGame'] == NULL || $ListGame['TourGame'] == 0) //Check if the game has started, the gane would be joignable
        {
            //Put the datas in the array $ShowGames
            array_push($ShowGames, array('idGame' => $ListGame['idGame'], 'LakeFishesGame' => $ListGame['LakeFishesGame'], 'LakeReproductionGame' => $ListGame['LakeReproductionGame'], 'PondReproductionGame' => $ListGame['PondReproductionGame'], 'EatFishesGame' => $ListGame['EatFishesGame'], 'FirstPlayerGame' => $ListGame['FirstPlayerGame'], 'TourGame' => $ListGame['TourGame'], 'SeasonTourGame' => $ListGame['SeasonTourGame'], 'MaxPlayersGame' => $ListGame['MaxPlayersGame'], 'MaxReleaseGame' => $ListGame['MaxReleaseGame'], 'DescriptionType' => $ListGame['DescriptionType'], 'OccupedPlaces' => $ListGame['OccupedPlaces'], 'UsedPlaces' => $ListGame['OccupedPlaces'].'/'.$ListGame['MaxPlayersGame'], 'Status' => 'En attente', 'CanJoin' => 'Yes'));
        }
        else //The game has started and is injoignable
        {
            //Put the datas in the array $ShowGames
            array_push($ShowGames, array('idGame' => $ListGame['idGame'], 'LakeFishesGame' => $ListGame['LakeFishesGame'], 'LakeReproductionGame' => $ListGame['LakeReproductionGame'], 'PondReproductionGame' => $ListGame['PondReproductionGame'], 'EatFishesGame' => $ListGame['EatFishesGame'], 'FirstPlayerGame' => $ListGame['FirstPlayerGame'], 'TourGame' => $ListGame['TourGame'], 'SeasonTourGame' => $ListGame['SeasonTourGame'], 'MaxPlayersGame' => $ListGame['MaxPlayersGame'], 'MaxReleaseGame' => $ListGame['MaxReleaseGame'], 'DescriptionType' => $ListGame['DescriptionType'], 'OccupedPlaces' => $ListGame['OccupedPlaces'], 'UsedPlaces' => $ListGame['OccupedPlaces'].'/'.$ListGame['MaxPlayersGame'], 'Status' => 'En cours', 'CanJoin' => 'No'));
        }
    }
    require('view/frontend/HomeView.php');

    $InfoAdmin = CheckAdmin($Pseudo); //Check if the player is an admin
    if($InfoAdmin ->rowCount() > 0) //Check if the user is an admin
    {
        require('view/frontend/AdminView.php'); //Show the button to go on the settings page
    }
}

//List all the settings
function GoSettings()
{
    $ListSettings = GetListSettings(); //Take the datas of the database

    $ShowSettings = array(); //Create the array for the settings
    foreach($ListSettings as $ListSetting)
    {
        //Put the datas in the array $ShowSettings
        array_push($ShowSettings, array('DescriptionSettings' => $ListSetting['DescriptionSettings'], 'ValueInt' => $ListSetting['ValueInt'], 'idSettings' => $ListSetting['idSettings']));
    }
    require('view/frontend/SettingsView.php');
}

//Update the Settings and go back to the settings page
function DoUpdateSettings($ValueIntForm, $IdUpdateSettings)
{
    UpdateSettings($ValueIntForm, $IdUpdateSettings);
    GoSettings();
}

//Join a place in a game
function GoGame($Pseudo, $IdJoinGame)
{
    $DisponobilityGame = CheckDisponiblityGame($IdJoinGame); //Check if there's a place on the game selected
    extract($DisponobilityGame); //$UsedPlaces, $MaxPlayersGame

    if($UsedPlaces < $MaxPlayersGame) //Create the place and take the infos of the game if there's a place
    {
        $GetBiggestOrder = GetBiggestOrder($IdJoinGame); //Get the biggest order
        $GetIdLogged = GiveIdLogged($Pseudo); //Get the id of the logged user
        $GetPondFishes = GetPondFishes(); //Get the default value of the amount of fishes to put in the pond

        extract($GetBiggestOrder); //$OrderPlace
        extract($GetIdLogged); //$idPlayer
        extract($GetPondFishes); //$ValueInt
        $OrderPlace++; //Biggest order +1 = my place
        CreatePlace($IdJoinGame, $OrderPlace, $idPlayer, $ValueInt); //Create the place of the player
        //$InfoGame = ShowInfoGame($Pseudo, $IdJoinGame);
    }
    else
    {
        $Error = "La place n'est plus disponible"; //Varriable to show the error message
        GoHome($Pseudo, $Error);
    }
    require('view/frontend/GameView.php'); //Show the button to go on the settings page
}
