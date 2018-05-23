<?php

require('model/frontend.php');

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
            $Error = "Ce pseudo existe déjà"; //Variable to show the error message
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
    $GetIdCreatedPlace = IdCreatedPlace($Pseudo);
    if($GetIdCreatedPlace == NULL) //The player isn't assigned to a place
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
    else
    {
        extract($GetIdCreatedPlace); //$idPlace, $fkGamePlace
        GoGame($idPlace, $fkGamePlace);
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
function DoCreatePlace($Pseudo, $IdJoinGame)
{
    $DisponobilityGame = CheckDisponiblityGame($IdJoinGame); //Check if there's a place on the game selected
    extract($DisponobilityGame); //$UsedPlaces, $MaxPlayersGame

    if($UsedPlaces < $MaxPlayersGame) //Create the place and take the infos of the game if there's a place
    {
        $GetBiggestOrder = GetBiggestOrder($IdJoinGame); //Get the biggest order
        $GetIdLogged = GiveIdLogged($Pseudo); //Get the id of the logged user
        $GetPondFishes = GetPondFishes(); //Get the default value of the amount of fishes to put in the pond

        if($GetBiggestOrder != NULL) //If there's no players on the game, the value won't be set
        {
            extract($GetBiggestOrder); //$OrderPlace
            $OrderPlace++; //Biggest order +1 = my place
        }
        else
        {
            $OrderPlace = 0;
        }
        extract($GetIdLogged); //$idPlayer
        extract($GetPondFishes); //$ValueInt

        $PlaceCreated = CreatePlace($IdJoinGame, $OrderPlace, $idPlayer, $ValueInt); //Create the place of the player
        if($PlaceCreated == 0) //The place couldn't be created
        {
            $Error = "Vous êtes déjà dans une partie"; //Variable to show the error message
            GoHome($Pseudo, $Error);
            return;
        }
        GoHome($Pseudo, NULL);
    }
    else //The place isn't free
    {
        $Error = "La place n'est plus disponible"; //Variable to show the error message
        GoHome($Pseudo, $Error);
        return;
    }
}

function GoGame($idPlace, $idGame)
{
    $InfoPlayers = ShowInfoPlayers($idGame); //Take infos about all the players
    $InfoGames = ShowInfoGames($idGame); //Take infos about the game

    $ShowPlayers = array(); //Create the array for the players
    foreach($InfoPlayers as $InfoPlayer)
    {
        //Put the datas in the array $ShowPlayers
        array_push($ShowPlayers, array('PondFishesPlace' => $InfoPlayer['PondFishesPlace'], 'FishedFishesPlace' => $InfoPlayer['FishedFishesPlace'], 'ReleasedFishesPlace' => $InfoPlayer['ReleasedFishesPlace'], 'OrderPlace' => $InfoPlayer['OrderPlace'], 'PseudoPlayer' => $InfoPlayer['PseudoPlayer'], 'RankingPlayer' => $InfoPlayer['RankingPlayer'], 'DescriptionStatus' => $InfoPlayer['DescriptionStatus']));

        if($InfoPlayer['OrderPlace'] == '0') //Select the pseudo of the first player to use it on a query
        {
            $FirstPlayer = $InfoPlayer['PseudoPlayer'];
        }
        if($InfoPlayer['DescriptionStatus'] == 'Joue' || $InfoPlayer['DescriptionStatus'] == 'Relâche des poissons') //Select the player who is playing
        {
            $FirstPlaying = $InfoPlayer['OrderPlace'];
        }
    }

    $ShowGameInfos = array(); //Create the array for informations about the game
    foreach($InfoGames as $InfoGame)
    {
        if(isset($FirstPlaying)) //Select the number of the next player who plays
        {
            //Put the datas in the array $ShowGames
            array_push($ShowGameInfos, array('LakeFishesGame' => $InfoGame['LakeFishesGame'], 'LakeReproductionGame' => $InfoGame['LakeReproductionGame'], 'PondReproductionGame' => $InfoGame['PondReproductionGame'], 'EatFishesGame' => $InfoGame['EatFishesGame'], 'FirstPlayerGame' => $InfoGame['FirstPlayerGame'], 'TourGame' => $InfoGame['TourGame'], 'SeasonTourGame' => $InfoGame['SeasonTourGame'], 'MaxPlayersGame' => $InfoGame['MaxPlayersGame'], 'MaxReleaseGame' => $InfoGame['MaxReleaseGame'], 'DescriptionType' => $InfoGame['DescriptionType'], 'OccupedPlaces' => $InfoGame['OccupedPlaces'], 'NextPlayer' => ($FirstPlaying + 6) % ($InfoGame['MaxPlayersGame'] -1)));
        }
        else
        {
            //Put the datas in the array $ShowGames
            array_push($ShowGameInfos, array('LakeFishesGame' => $InfoGame['LakeFishesGame'], 'LakeReproductionGame' => $InfoGame['LakeReproductionGame'], 'PondReproductionGame' => $InfoGame['PondReproductionGame'], 'EatFishesGame' => $InfoGame['EatFishesGame'], 'FirstPlayerGame' => $InfoGame['FirstPlayerGame'], 'TourGame' => $InfoGame['TourGame'], 'SeasonTourGame' => $InfoGame['SeasonTourGame'], 'MaxPlayersGame' => $InfoGame['MaxPlayersGame'], 'MaxReleaseGame' => $InfoGame['MaxReleaseGame'], 'DescriptionType' => $InfoGame['DescriptionType'], 'OccupedPlaces' => $InfoGame['OccupedPlaces'], 'NextPlayer' => 'Pas défini'));
        }
    }

    if($InfoGame['OccupedPlaces'] >= $InfoGame['MaxPlayersGame']) //Check if the game has started
    {
        if($InfoGame['TourGame'] == NULL) //If the first round hasn't start, the game starts
        {
            StartGame($idGame, $FirstPlayer); //The game has started
        }
    }
    else //Tell to the players, the game hasn't started
    {
        $NeededPlayers = $InfoGame['MaxPlayersGame'] - $InfoGame['OccupedPlaces'];
        $Error = "En attente de ".$NeededPlayers." joueurs";
    }
    require('view/frontend/GameView.php'); //Show the game selected by the player
}

//Delete the place and redirect to the home page
function DoDeletePlace($IdLeavePlace)
{
    DeletePlace($IdLeavePlace);
    unset($_SESSION['$idPlace']);
    unset($_SESSION['$idGame']);
    unset($idPlace);
    unset($idGame);
    GoHome($_SESSION['Pseudo'], NULL);
}

//Fish in the lake
function doFish($NbFishing, $idPlace, $idGame)
{
    Fish($NbFishing, $idPlace, $idGame);
    GoGame($idPlace, $idGame);
}

/*The player pass her round and wait the next
function DoPassRound($idPlace, $idGame)
{
    echo $NextPlayer.'<br>';
    GoGame($idPlace, $idGame);
    //PassRound($idPlace);
}*/
