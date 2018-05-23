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

    return $req;
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

    return $req;
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
    INNER JOIN fishermenland.status ON place.fkStatusPlace = status.idStatus WHERE fkGamePlace = '$idGame'");

    return $req;
}

//Show all the infos of a specific game
function ShowInfoGames($idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, DescriptionType, (SELECT COUNT(idPlace) FROM fishermenland.place WHERE fkGamePlace = idGame) AS OccupedPlaces
    FROM fishermenland.game
    INNER JOIN fishermenland.type ON game.fkTypeGame = type.idType WHERE idGame = '$idGame'");

    return $req;
}

//Delete the place of the player
function DeletePlace($IdLeavePlace)
{
    $dbh = ConnectDB();
    $req = $dbh->query("DELETE FROM fishermenland.place WHERE idPlace = '$IdLeavePlace'");

    return $req;
}

//Fish in the lake
function Fish($NbFishing, $idPlace, $idGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.place SET PondFishesPlace = PondFishesPlace + '$NbFishing', FishedFishesPlace = FishedFishesPlace + '$NbFishing' WHERE idPlace = '$idPlace'");
    $req = $dbh->query("UPDATE fishermenland.game SET LakeFishesGame = LakeFishesGame - '$NbFishing' WHERE idGame = '$idGame'");

    return $req;
}

//The first tour start, the name of the first player is saved and the first player have to play
function StartGame($idGame, $FirstPlayer)
{
    $dbh = ConnectDB();
    $req = $dbh->query("UPDATE fishermenland.game SET TourGame = '1', FirstPlayerGame = '$FirstPlayer' WHERE idGame = '$idGame' AND TourGame IS NULL");
    $req = $dbh->query("UPDATE fishermenland.place SET fkStatusPlace = '2' WHERE fkPlayerPlace = (SELECT idPlayer FROM fishermenland.player WHERE PseudoPlayer = '$FirstPlayer')");

    return $req;
}
