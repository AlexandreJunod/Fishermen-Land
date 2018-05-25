<?php

//Save the session when the Access was accepted after a login or a signup
function AccessAccepted($Pseudo, $idPlayer)
{
    $_SESSION['Pseudo'] = $Pseudo;
    $_SESSION['MyID'] = $idPlayer;
    GoHome($Pseudo, NULL);
}

//Create the array $ShowPlayers
function GetShowPlayers($idGame)
{
    $InfoPlayers = ShowInfoPlayers($idGame); //Take infos about all the players

    $ShowPlayers = array(); //Create the array for the players
    foreach($InfoPlayers as $InfoPlayer)
    {
        //Put the datas in the array $ShowPlayers
        array_push($ShowPlayers, array('idPlace' => $InfoPlayer['idPlace'] ,'PondFishesPlace' => $InfoPlayer['PondFishesPlace'], 'FishedFishesPlace' => $InfoPlayer['FishedFishesPlace'], 'ReleasedFishesPlace' => $InfoPlayer['ReleasedFishesPlace'], 'OrderPlace' => $InfoPlayer['OrderPlace'], 'PseudoPlayer' => $InfoPlayer['PseudoPlayer'], 'RankingPlayer' => $InfoPlayer['RankingPlayer'], 'DescriptionStatus' => $InfoPlayer['DescriptionStatus']));
    }
    return $ShowPlayers;
}

//Create the array $ShowGameInfos
function GetShowGameInfos($idGame)
{

    $InfoGames = ShowInfoGames($idGame); //Take infos about the game
    $ShowPlayers = GetShowPlayers($idGame); //Take the info about the players

    foreach($ShowPlayers as $ShowPlayer)
    {
        if($ShowPlayer['OrderPlace'] == '0') //Select the pseudo of the first player to use it on a query
        {
            $NextFirstPlayer = $ShowPlayer['PseudoPlayer'];
        }

        if($ShowPlayer['DescriptionStatus'] == 'Joue' || $ShowPlayer['DescriptionStatus'] == 'Relâche des poissons') //Select the player who is playing
        {
            $CurrentPlayer = $ShowPlayer['PseudoPlayer'];
            $idCurrentPlayer = $ShowPlayer['OrderPlace'];
            $StatusPlayer = $ShowPlayer['DescriptionStatus'];
        }
    }

    $ShowGameInfos = array(); //Create the array for informations about the game
    foreach($InfoGames as $InfoGame)
    {
        if(isset($CurrentPlayer)) //Select the number of the next player who plays
        {
            //Put the datas in the array $ShowGames
            array_push($ShowGameInfos, array('idGame' =>  $InfoGame['idGame'],'LakeFishesGame' => $InfoGame['LakeFishesGame'], 'LakeReproductionGame' => $InfoGame['LakeReproductionGame'], 'PondReproductionGame' => $InfoGame['PondReproductionGame'], 'EatFishesGame' => $InfoGame['EatFishesGame'], 'FirstPlayerGame' => $InfoGame['FirstPlayerGame'], 'TourGame' => $InfoGame['TourGame'], 'SeasonTourGame' => $InfoGame['SeasonTourGame'], 'MaxPlayersGame' => $InfoGame['MaxPlayersGame'], 'MaxReleaseGame' => $InfoGame['MaxReleaseGame'], 'DescriptionType' => $InfoGame['DescriptionType'], 'OccupedPlaces' => $InfoGame['OccupedPlaces'], 'CurrentPlayer' => $CurrentPlayer, 'Action' => $StatusPlayer, 'NextPlayer' => ($idCurrentPlayer + 1) % $InfoGame['MaxPlayersGame'], 'NextFirstPlayer' => 'Non disponible'));
        }
        else
        {
            //Put the datas in the array $ShowGames
            array_push($ShowGameInfos, array('idGame' =>  $InfoGame['idGame'], 'LakeFishesGame' => $InfoGame['LakeFishesGame'], 'LakeReproductionGame' => $InfoGame['LakeReproductionGame'], 'PondReproductionGame' => $InfoGame['PondReproductionGame'], 'EatFishesGame' => $InfoGame['EatFishesGame'], 'FirstPlayerGame' => $InfoGame['FirstPlayerGame'], 'TourGame' => $InfoGame['TourGame'], 'SeasonTourGame' => $InfoGame['SeasonTourGame'], 'MaxPlayersGame' => $InfoGame['MaxPlayersGame'], 'MaxReleaseGame' => $InfoGame['MaxReleaseGame'], 'DescriptionType' => $InfoGame['DescriptionType'], 'OccupedPlaces' => $InfoGame['OccupedPlaces'], 'CurrentPlayer' => 'Pas défini', 'Action' =>' Pas défini' ,'NextPlayer' => 'Pas défini', 'NextFirstPlayer' => $NextFirstPlayer));
        }
    }
    return $ShowGameInfos;
}
