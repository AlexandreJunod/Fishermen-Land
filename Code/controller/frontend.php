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
                AccessAccepted($Pseudo, $idPlayer);
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
            DoLogin($Pseudo, $Password); //Login the player
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
        $ListGames = GetListGames(); //List all the games

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
        GoGame($idPlace, $fkGamePlace, $Error);
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
    header('Location: index.php'); //Prevent to spam form
    UpdateSettings($ValueIntForm, $IdUpdateSettings);
    GoSettings();
}

//Join a place in a game
function DoCreatePlace($Pseudo, $IdJoinGame)
{
    header('Location: index.php'); //Prevent to spam form
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

function GoGame($idPlace, $idGame, $Error)
{
    $ShowPlayers = GetShowPlayers($idGame); //Get the array $ShowPlayers
    $ShowGameInfos = GetShowGameInfos($idGame); //Get the array $ShowGameInfos

    foreach($ShowGameInfos as $ShowGameInfo)
    {
        if($ShowGameInfo['TourGame'] == NULL && $ShowGameInfo['OccupedPlaces'] >= $ShowGameInfo['MaxPlayersGame']) //If the first round hasn't start and game is full, the game starts
        {
            if($ShowGameInfo['NextFirstPlayer'] != 'Non disponible') //Prevent to assign "Non disponible" as first user
            {
                if($_SESSION['Pseudo'] == $ShowGameInfo['NextFirstPlayer'] ) //Only the first player can start the game
                {
                    if($ShowGameInfo['NextFirstPlayer'] == $ShowGameInfo['FirstPlayerGame']) //Doesn't allow the player to play 2 times first
                    {
                        ChangeOrder($idGame, $ShowGameInfo['MaxPlayersGame']);
                        return;
                    }
                    else
                    {
                        StartGame($idGame, $ShowGameInfo['NextFirstPlayer']); //The game has started
                    }
                }
            }
        }
        elseif($ShowGameInfo['TourGame'] == NULL) //Tell to the players how many players are missing when the game hasn't started
        {
            $NeededPlayers = $ShowGameInfo['MaxPlayersGame'] - $ShowGameInfo['OccupedPlaces'];
            $Error = "En attente de ".$NeededPlayers." joueurs";
        }
        elseif($ShowGameInfo['TourGame'] >= $ShowGameInfo['SeasonTourGame'] || $ShowGameInfo['OccupedPlaces']<=1) //The game has ended
        {
            $Error = "Vous n'avez que 15 secondes pour recommencer une partie";
            UpdateTourGame($idGame); //Put at 999 the TourGame. In case of the game end by 1 player leaving the game, tge game has to be able to reset
            GoEndGame($idPlace, $idGame, $Error); //Show the scores
            return;
        }

        if($ShowGameInfo['CurrentPlayer'] == $_SESSION['Pseudo']) //Show the buttons to the player who is playing
        {
            switch ($ShowGameInfo['Action']){ //Select wich actions the player can do
                case 'Joue':
                    require('view/frontend/GamePlayingView.php'); //Show the buttons for playing
                    break;
                case 'Relâche des poissons':
                    require('view/frontend/GameReleasingView.php'); //Show the buttons for releasing
                    break;
            }
        }
        else //The player isn't playing
        {
            ?><script>setInterval(function(){location.reload()},3000);</script><?php // Refresh the page
        }
    }
    require('view/frontend/GameView.php'); //Show the game selected by the player
}

//Go to the page where the scores are showed, after winning or losing a game. Save the game in the history
function GoEndGame($idPlace, $idGame, $Error)
{
    $ShowPlayers = GetShowPlayers($idGame); //Get the array $ShowPlayers
    $ShowGameInfos = GetShowGameInfos($idGame); //Get the array $ShowGameInfos

    foreach($ShowGameInfos as $ShowGameInfo)
    {
        $CommonScore = $ShowGameInfo['LakeFishesGame'];
        $CollectiveScore = $ShowGameInfo['LakeFishesGame'] + $ShowGameInfo['SumPondFishes'];
    }

    foreach($ShowPlayers as $ShowPlayer)
    {
        if($ShowPlayer['idPlace'] == $idPlace)
        {
            $IndividualScore = $ShowPlayer['PondFishesPlace'] + $CommonScore;
        }
    }
    DoUpdateRank($IndividualScore);
    require('view/frontend/EndGameView.php'); //Show the game selected by the player
}

//Delete the place, create a new place and verify if the first player on the last game was not this player
function DoReplayGame($Pseudo, $idGame)
{
    $ShowPlayers = GetShowPlayers($idGame); //Get the array $ShowPlayers
    $ShowGameInfos = GetShowGameInfos($idGame); //Get the array $ShowGameInfos


    foreach($ShowPlayers as $ShowPlayer)
    {
        if($ShowPlayer['PseudoPlayer'] == $Pseudo)
        {
            foreach($ShowGameInfos as $ShowGameInfo)
            {
                if($ShowGameInfo['TourGame'] >= $ShowGameInfo['SeasonTourGame']) //Allows the code to reset only one time
                {
                    sleep(1); //Wait1 sec before reset;
                    DeletePlaces($idGame); //Delete all the places of this game
                    ResetGame($idGame); //Reset the game
                }
            }
        }
    }
    DoCreatePlace($Pseudo, $_SESSION['idGame']);
    return;
}

//Delete the place, change place of other players and redirect to the home page
function DoDeletePlace($IdLeavePlace, $idGame)
{
    header('Location: index.php'); //Prevent to spam form
    $ShowPlayers = GetShowPlayers($idGame); //Get the array $ShowPlayers
    foreach($ShowPlayers as $ShowPlayer)
    {
        if($ShowPlayer['idPlace'] == $IdLeavePlace)
        {
            ChangeOrderAfterLeave($IdLeavePlace, $idGame, $ShowPlayer['OrderPlace']);
        }
    }

    DeletePlace($IdLeavePlace);
    unset($_SESSION['$idPlace']);
    unset($_SESSION['$idGame']);
    unset($idPlace);
    unset($idGame);
    GoHome($_SESSION['Pseudo'], NULL);
}

//Fish in the lake
function DoFish($NbFishing, $idPlace, $idGame)
{
    $ShowPlayers = GetShowPlayers($idGame); //Get the array $ShowPlayers
    foreach($ShowPlayers as $ShowPlayer)
    {
        if($ShowPlayer['idPlace'] == $idPlace)
        {
            $ShowGameInfos = GetShowGameInfos($idGame); //Get the array $ShowGameInfos
            foreach($ShowGameInfos as $ShowGameInfo){} //Create the array $ShowGameInfo for check values

            if($NbFishing > $ShowPlayer['PondFishesPlace']) //The player is trying to fish more than the number on his pond
            {
                $Error = "Vous ne pouvez pas pêcher plus de poissons que ce que vous possédez déjà";
                GoHome($_SESSION['Pseudo'], $Error);
            }
            elseif($NbFishing > $ShowGameInfo['LakeFishesGame'])
            {
                $Error = "Vous ne pouvez pas pêcher plus de poissons que ce que le lac ne possède";
                GoHome($_SESSION['Pseudo'], $Error);
            }
            else
            {
                Fish($NbFishing, $idPlace, $idGame);
                DoPassRound($ShowGameInfo['NextPlayer'], $idPlace, $idGame);
            }
        }
    }
}

function DoRelease($PassRound, $NbReleasing, $idPlace, $idGame)
{
    $ShowPlayers = GetShowPlayers($idGame); //Get the array $ShowPlayers
    foreach($ShowPlayers as $ShowPlayer)
    {
        if($ShowPlayer['idPlace'] == $idPlace)
        {
            $ShowGameInfos = GetShowGameInfos($idGame); //Get the array $ShowGameInfos
            foreach($ShowGameInfos as $ShowGameInfo){} //Create the array $ShowGameInfo for check values

            if($NbReleasing > $ShowPlayer['PondFishesPlace']) //The player is trying to fish more than the number on his pond
            {
                $Error = "Vous ne pouvez pas relâcher plus de poissons que ce que vous ne possédez";
                GoHome($_SESSION['Pseudo'], $Error);
            }
            else
            {
                Release($NbReleasing, $idPlace, $idGame);
                DoPassRound($PassRound, $idPlace, $idGame);
            }
        }
    }
}

//Change de status of the current user and of the next user
function DoPassRound($PassRound, $idPlace, $idGame)
{
    header('Location: index.php'); //Prevent to spam form
    $ShowPlayers = GetShowPlayers($idGame); //Get the array $ShowPlayers
    $ShowGameInfos = GetShowGameInfos($idGame); //Get the array $ShowGameInfos

    foreach($ShowGameInfos as $ShowGameInfo)
    {
        if($ShowGameInfo['idGame'] == $idGame)
        {
            foreach($ShowPlayers as $ShowPlayer) //Take the infos about the players
            {
                if($ShowPlayer['idPlace'] == $idPlace)
                {
                    if($ShowGameInfo['DescriptionType'] == 'Coopératif' && $ShowPlayer['DescriptionStatus'] == 'Joue') //If game is on cooperative, player will have to select an amount of fishes to drop
                    {
                        ChangeStatusRelease($idPlace);
                    }
                    else //The player haven't to drop fishes
                    {
                        DoAddTour($ShowGameInfo['NextPlayer'], $idGame);
                        PassRound($PassRound, $idPlace, $idGame);
                    }
                }
            }
        }
    }
    GoGame($idPlace, $idGame, NULL);
}

//Add 1 tour when it's a new tour
function DoAddTour($NextPlayer, $idGame)
{
    if($NextPlayer == 0) //if the next player is 0, add a tour and fishes make new fishes.Players hit 2 fishes
    {
        AddTour($idGame);
        $ShowGameInfos = GetShowGameInfos($idGame); //Get the array $ShowGameInfos

        foreach($ShowGameInfos as $ShowGameInfo)
        {
            if($ShowGameInfo['TourGame'] < $ShowGameInfo['SeasonTourGame']) //if this is the game who is starting a new round and this isn't the last round, give new fishes
            {
                EatPondFishes($idGame, $ShowGameInfo['EatFishesGame']);
                AddNewFishes($ShowGameInfo['LakeReproductionGame'], $ShowGameInfo['PondReproductionGame']);
            }
        }
    }
}

//To calculate the rank make an AVG() of all the scores grouped by the id of the player who make theses scores, and sort in ascending order. Next foreach entry give a rank with the id on the array
function DoUpdateRank($IndividualScore)
{
    SaveGame($_SESSION['MyID'], $IndividualScore);
    $ListRanks = CheckRank();
    $Rank = 0;

    //$ArrayWithRanks = array(); //Create the array for keep the ranks and a number
    foreach($ListRanks as $ListRanks)
    {
        $Rank++;
        UpdateRank($Rank, $ListRanks['fkPlayerHistory']); //Change the rank of all players
    }
}
