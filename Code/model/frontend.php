<?php

//Connect to the database
function ConnectDB()
{
    //Required datas for connect to a database
    $hostname = 'localhost';
    $dbname = 'fishermenland';
    $username = 'root';
    $password = '';

    // PDO = Persistant Data Object
    // Between "" = Connection String
    $connectionString = "mysql:host=$hostname; dbname=$dbname";

    $dbh = new PDO($connectionString, $username, $password);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->exec("SET NAMES UTF8");

    return $dbh;
}

//Select the player with the informations sent by the user
function Login($Pseudo, $Password)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idPlayer, PseudoPlayer, PasswordPlayer, MD5('$Password') AS HashPassword FROM fishermenland.player WHERE PseudoPlayer = '$Pseudo'");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Check if the pseudo sent by the user is on the database
function CheckAccount($Pseudo)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idPlayer, PseudoPlayer, PasswordPlayer FROM fishermenland.player WHERE PseudoPlayer = '$Pseudo'");

    return $req;
}

//Create the account of the user
function Signup($Pseudo, $Password)
{
    $dbh = ConnectDB();
    $req = $dbh->query("INSERT INTO fishermenland.player (PseudoPlayer, PasswordPlayer) VALUES ('$Pseudo', MD5('$Password'))");
}

//Check if the user is an admin
function CheckAdmin($Pseudo)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT AdminPlayer FROM fishermenland.player WHERE PseudoPlayer = '$Pseudo' AND AdminPlayer = '1'");

    return $req;
}

//Get the list of the games
function GetListGames()
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idGame, LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, DescriptionType, (SELECT COUNT(idPlace) FROM fishermenland.place WHERE fkGamePlace = idGame) AS OccupedPlaces
    FROM fishermenland.game
    INNER JOIN fishermenland.type ON game.fkTypeGame = type.idType GROUP BY idGame");

    return $req;
}

//Get the joignable and not empty "Coopératif" games and the total of games
function GetCooperative()
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT COUNT(idGame) AS Joignable, (SELECT COUNT(DISTINCT idGame) FROM fishermenland.game INNER JOIN fishermenland.place ON game.idGame = place.fkGamePlace WHERE fkTypeGame = '1' GROUP BY fkTypeGame) AS NotEmpty, (SELECT COUNT(idGame) FROM fishermenland.game WHERE fkTypeGame = '1') AS TotalGames FROM fishermenland.game WHERE fkTypeGame = '1' AND TourGame IS NULL");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Get the joignable and not empty "Imposition" games and the total of games
function GetImpostion()
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT COUNT(idGame) AS Joignable, (SELECT COUNT(DISTINCT idGame) FROM fishermenland.game INNER JOIN fishermenland.place ON game.idGame = place.fkGamePlace WHERE fkTypeGame = '2' GROUP BY fkTypeGame) AS NotEmpty, (SELECT COUNT(idGame) FROM fishermenland.game WHERE fkTypeGame = '2') AS TotalGames FROM fishermenland.game WHERE fkTypeGame = '2' AND TourGame IS NULL");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Get the joignable and not empty "Imposition avec frofait" games and the total of games
function GetImpostionForfait()
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT COUNT(idGame) AS Joignable, (SELECT COUNT(DISTINCT idGame) FROM fishermenland.game INNER JOIN fishermenland.place ON game.idGame = place.fkGamePlace WHERE fkTypeGame = '3' GROUP BY fkTypeGame) AS NotEmpty, (SELECT COUNT(idGame) FROM fishermenland.game WHERE fkTypeGame = '3') AS TotalGames FROM fishermenland.game WHERE fkTypeGame = '3' AND TourGame IS NULL");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Create a "Coopératif" game
function CreateCooperative()
{
    $dbh = ConnectDB();
    $req = $dbh->query("INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ((SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'DefaultLakeFishes'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'LakeReproduction'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'PondReproduction'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'EatenFishes'), NULL, NULL, (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'SeasonTour'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'MaxPlayers'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'ReleaseMax'), '1')");
}

//Create a "Imposition" game
function CreateImpostion()
{
    $dbh = ConnectDB();
    $req = $dbh->query("INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ((SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'DefaultLakeFishes'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'LakeReproduction'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'PondReproduction'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'EatenFishes'), NULL, NULL, (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'SeasonTour'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'MaxPlayers'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'ReleaseMax'), '2')");
}

//Create a "Imposition avec forfait" game
function CreateImpostionForfait()
{
    $dbh = ConnectDB();
    $req = $dbh->query("INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ((SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'DefaultLakeFishes'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'LakeReproduction'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'PondReproduction'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'EatenFishes'), NULL, NULL, (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'SeasonTour'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'MaxPlayers'), (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'ReleaseMax'), '3')");
}

//Delete a "Coopératif" game
function DeleteCooperative()
{
    $dbh = ConnectDB();
    $req = $dbh->query("DELETE FROM fishermenland.game WHERE idGame IN (SELECT idGame FROM (SELECT idGame FROM fishermenland.game WHERE fkTypeGame = '1' GROUP BY idGame DESC LIMIT 1) temp)");
}

//Delete a "Imposition" game
function DeleteImpostion()
{
    $dbh = ConnectDB();
    $req = $dbh->query("DELETE FROM fishermenland.game WHERE idGame IN (SELECT idGame FROM (SELECT idGame FROM fishermenland.game WHERE fkTypeGame = '2' GROUP BY idGame DESC LIMIT 1) temp)");
}

//Delete a "Imposition avec forfait" game
function DeleteImpostionForfait()
{
    $dbh = ConnectDB();
    $req = $dbh->query("DELETE FROM fishermenland.game WHERE idGame IN (SELECT idGame FROM (SELECT idGame FROM fishermenland.game WHERE fkTypeGame = '3' GROUP BY idGame DESC LIMIT 1) temp)");
}

//Get the rank
function GetRank($Pseudo)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT RankingPlayer FROM fishermenland.player WHERE PseudoPlayer = '$Pseudo'");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Get the list of the settings who could be changed
function GetListSettings()
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idSettings, NameSettings, ValueInt, ValueDate, ValueChar, DescriptionSettings FROM fishermenland.settings");

    return $req;
}

//Update the settings with the datas given by the admin
function UpdateSettings($ValueIntForm, $IdUpdateSettings)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.settings SET ValueInt = '$ValueIntForm' WHERE idSettings = '$IdUpdateSettings'");
}

//Check if the game chosen by the user still not full
function CheckDisponiblityGame($IdJoinGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT MaxPlayersGame, (SELECT COUNT(fkGamePlace) FROM fishermenland.place WHERE fkGamePlace = '$IdJoinGame') as UsedPlaces FROM fishermenland.game WHERE idGame = '$IdJoinGame'");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Gives the biggest value in the OrderPlace
function GetBiggestOrder($IdJoinGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT OrderPlace FROM fishermenland.place WHERE fkGamePlace = '$IdJoinGame' ORDER BY OrderPlace DESC LIMIT 1");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Gives the ID of the player logged
function GiveIdLogged($Pseudo)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idPlayer FROM fishermenland.player WHERE PseudoPlayer = '$Pseudo'");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Gives the default nomber of fishes in the pond
function GetPondFishes()
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT ValueInt FROM fishermenland.settings  WHERE NameSettings = 'DefaulPondFishes'");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Create the place of the player
function CreatePlace($IdJoinGame, $OrderPlace, $idPlayer, $ValueInt)
{
    $dbh = ConnectDB();
    $req = $dbh->query("INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('$ValueInt', '0', '0', '$OrderPlace', '$idPlayer', '1', '$IdJoinGame')");

    //Verify if query was accepted
    if($req)
    {
        $result = 1;
    }
    else
    {
        $result = 0;
    }
    return $result;
}

//Take the id of the place of the player
function IdCreatedPlace($Pseudo)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idPlace, fkGamePlace FROM fishermenland.place INNER JOIN fishermenland.player ON fkPlayerPlace = idPlayer WHERE PseudoPlayer = '$Pseudo'");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Show all the infos needed in game
function ShowInfoPlayers($idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idPlace, PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, PseudoPlayer, RankingPlayer, DescriptionStatus FROM fishermenland.place
    INNER JOIN fishermenland.player ON place.fkPlayerPlace = player.idPlayer
    INNER JOIN fishermenland.status ON place.fkStatusPlace = status.idStatus WHERE fkGamePlace = '$idGame' ORDER BY OrderPlace ASC");

    return $req;
}

//Show all the infos of a specific game
function ShowInfoGames($idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idGame, LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, DescriptionType, (SELECT COUNT(idPlace) FROM fishermenland.place WHERE fkGamePlace = idGame) AS OccupedPlaces, (SELECT SUM(PondFishesPlace) FROM fishermenland.place WHERE fkGamePlace = idGame) AS SumPondFishes
    FROM fishermenland.game
    INNER JOIN fishermenland.type ON game.fkTypeGame = type.idType WHERE idGame = '$idGame'");

    return $req;
}

//Fish in the lake
function Fish($NbFishing, $idPlace, $idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.place SET PondFishesPlace = PondFishesPlace + CEILING($NbFishing), FishedFishesPlace = FishedFishesPlace + CEILING($NbFishing) WHERE idPlace = '$idPlace'");
    $req = $dbh->query("UPDATE fishermenland.game SET LakeFishesGame = LakeFishesGame - CEILING($NbFishing) WHERE idGame = '$idGame'");
}

//Release fishes from the pond
function Release($NbReleasing, $idPlace, $idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.place SET PondFishesPlace = PondFishesPlace - CEILING($NbReleasing), ReleasedFishesPlace = ReleasedFishesPlace + CEILING($NbReleasing) WHERE idPlace = '$idPlace'");
    $req = $dbh->query("UPDATE fishermenland.game SET LakeFishesGame = LakeFishesGame + CEILING($NbReleasing) WHERE idGame = '$idGame'");
}

//Change the status from "Joue" in "Relâche des poissons"
function ChangeStatusRelease($idPlace)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.place SET fkStatusPlace = '3' WHERE idPlace = '$idPlace'");
}

//The first tour start, the name of the first player is saved and the first player have to play
function StartGame($idGame, $FirstPlayer)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.game SET TourGame = '1', FirstPlayerGame = '$FirstPlayer' WHERE idGame = '$idGame' AND TourGame IS NULL");
    $req = $dbh->query("UPDATE fishermenland.place SET fkStatusPlace = '2' WHERE fkPlayerPlace = (SELECT idPlayer FROM fishermenland.player WHERE PseudoPlayer = '$FirstPlayer')");
}

//Step 1 : The player is set to "En attente"
//Step 2 : The next player can play
function PassRound($PassRound, $idGame, $idPlace)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.place SET fkStatusPlace = '1' WHERE idPlace = '$idPlace'");
    $req = $dbh->query("UPDATE fishermenland.place SET fkStatusPlace = '2' WHERE fkGamePlace = '$idGame' AND OrderPlace = '$PassRound'");
}

//Check the rank of all player and return the datas
function CheckRank()
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT AVG(ScoreHistory) AS AVGScoreHistory, fkPlayerHistory FROM fishermenland.history  GROUP BY fkPlayerHistory ASC HAVING COUNT(fkPlayerHistory) >= (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'NeededGameToRank')");

    return $req;
}

//Delete the ranks and next update the rank of all players who have the number of required games
function UpdateRank($Rank, $fkPlayerHistory)
{
    $dbh = ConnectDB();
    //$req = $dbh->query("UPDATE fishermenland.player SET RankingPlayer = NULL");
    $req = $dbh->query("UPDATE fishermenland.player SET RankingPlayer = '$Rank' WHERE idPlayer = '$fkPlayerHistory'");
}

//Save the game in the history
function SaveGame($idPlayer, $IndividualScore)
{
    $dbh = ConnectDB();
    $req = $dbh->query("INSERT INTO fishermenland.history (ScoreHistory, fkPlayerHistory) VALUES ('$IndividualScore','$idPlayer')");
}

//New tour is starting
function AddTour($idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.game SET TourGame = TourGame + '1' WHERE idGame = '$idGame'");
}

//Add new fishes in the pond and the Lake
function AddNewFishes($LakeReproductionGame, $PondReproductionGame, $idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.game SET LakeFishesGame = FLOOR((LakeFishesGame/2))*$LakeReproductionGame+LakeFishesGame WHERE idGame = '$idGame'");
    $req = $dbh->query("UPDATE fishermenland.place SET PondFishesPlace = FLOOR((PondFishesPlace/2))*$PondReproductionGame+PondFishesPlace");
}

//Reset the game
function ResetGame($idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.game SET LakeFishesGame = (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'DefaultLakeFishes'), LakeReproductionGame = (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'LakeReproduction'), PondReproductionGame = (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'PondReproduction'), EatFishesGame = (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'EatenFishes'), TourGame = NULL, SeasonTourGame = (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'SeasonTour'), MaxPlayersGame = (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'MaxPlayers'), MaxReleaseGame = (SELECT ValueInt FROM fishermenland.settings WHERE NameSettings = 'ReleaseMax') WHERE idGame = '$idGame'");
}

//Delete the place of the player
function DeletePlace($idPlace)
{
    $dbh = ConnectDB();
    $req = $dbh->query("DELETE FROM fishermenland.place WHERE idPlace = '$idPlace'");
}

//Delete all the players on a game
function DeletePlaces($idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("DELETE FROM fishermenland.place WHERE fkGamePlace = '$idGame'");
}

//Change the order of all players
function ChangeOrder($idGame, $MaxPlayers)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.place SET OrderPlace = (OrderPlace +1)%$MaxPlayers WHERE fkGamePlace = '$idGame'");
}

//Change the order of all players playing after the player leaving
function ChangeOrderAfterLeave($idPlace, $idGame, $OrderPlace)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.place SET OrderPlace = OrderPlace - 1 WHERE OrderPlace > $OrderPlace AND fkGamePlace ='$idGame'");
}

//Put TourGame at 999
function UpdateTourGame($idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.game SET TourGame = '999' WHERE idGame = '$idGame'");
}

//Eat fishes
function EatPondFishes($idGame, $FishesToEat)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.place SET PondFishesPlace = PondFishesPlace - $FishesToEat WHERE fkGamePlace = '$idGame'");
}

//Get the best score of 1 player
function GetBestScore($idPlayer)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idHistory, ScoreHistory FROM fishermenland.history WHERE fkPlayerHistory = '$idPlayer' ORDER BY ScoreHistory ASC LIMIT 1");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Put the status of the player on "Eliminé" and drop the fishes
function LostGame($idPlace)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.place SET PondFishesPlace = '0', fkStatusPlace = '4' WHERE idPlace = '$idPlace'");
}
