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

//Get the list of the games and the datas
function GetListGames()
{
    $dbh = ConnectDB();
    $req = $dbh->query("SELECT idGame, LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, DescriptionType, COUNT(idPlace) AS OccupedPlaces
    FROM fishermenland.game
    INNER JOIN fishermenland.type ON game.fkTypeGame = type.idType
    INNER JOIN fishermenland.place ON game.idGame = place.fkGamePlace GROUP BY idGame");

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
    $req = $dbh->query("SELECT MaxPlayersGame, (SELECT COUNT(fkGamePlace) as UsedPlaces FROM fishermenland.place WHERE fkGamePlace = '$IdJoinGame') FROM fishermenland.game WHERE idGame = '$IdJoinGame'");
    $reqArray = $req->fetch();

    return $reqArray;
}

//Create the place of the player
function CreatePlace($Pseudo, $IdJoinGame)
{
    $dbh = ConnectDB();
    $req = $dbh->query("");

    return $req;
}

//Show all the infos needed in game
function ShowInfoGame($Pseudo, $IdJoinGame)
{

}
