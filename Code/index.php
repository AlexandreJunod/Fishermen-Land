<?php
session_start();
require('controller/frontend.php');
require('function/function.php');

//error_log(print_r($_POST, 1));

try
{
    if(isset($_SESSION['Pseudo'])) //The user has a session with his pseudo saved
    {
        if(isset($_POST['Settings'])) //The user want to go on settings or change the value of one setting
        {
            GoSettings($_SESSION['Pseudo']);
        }
        elseif(isset($_POST['IdUpdateSettings'])) //The admin changed one value in the database
        {
            DoUpdateSettings($_POST['ValueIntForm'], $_POST['IdUpdateSettings']);
        }
        elseif(isset($_POST['IdJoinGame'])) //The user want to join a game
        {
            DoCreatePlace($_SESSION['Pseudo'], $_POST['IdJoinGame']);
        }
        elseif(isset($_POST['LeaveGame'])) //The player wants to leave the game
        {
            DoDeletePlace($_POST['LeaveGame'], $_SESSION['idGame']);
        }
        elseif(isset($_POST['DisconnectForm'])) //Disconnect and goes to the connexion page
        {
            DoDisconnect();
        }
        elseif(isset($_POST['NbFishing'])) //The player is fishing
        {
            DoFish($_POST['NbFishing'], $_SESSION['idPlace'], $_SESSION['idGame']);
        }
        elseif(isset($_POST['NbReleasing'])) //The player is releasing fishes
        {
            if(!isset($_POST['Release'])) //Release 0 fishes if the user hasn't type a number
            {
                $_POST['Release'] = '0';
            }
            DoRelease($_POST['Release'], $_POST['NbReleasing'], $_SESSION['idPlace'], $_SESSION['idGame']);
        }
        elseif(isset($_POST['PassRound'])) //The player pass her round
        {
            DoPassRound($_POST['PassRound'], $_SESSION['idPlace'], $_SESSION['idGame']);
        }
        elseif(isset($_POST['ReplayGame'])) //The player want to replay the game
        {
            DoReplayGame($_SESSION['Pseudo'], $_SESSION['idGame']);
        }
        elseif(isset($_POST['GoHomeButton']))
        {
            header('location: index.php'); //Prevent to send the form multiple times
            GoHome($_SESSION['Pseudo'], NULL);
        }
        else //The user is logged and did nothing
        {
            GoHome($_SESSION['Pseudo'], NULL);
        }
    }
    elseif(isset($_GET['Signup'])) //The user want to signup
    {
        if(isset($_POST['Signup'])) //The user has send a form for signup
        {
            DoSignup($_POST['PseudoForm'], $_POST['PasswordForm']);
        }
        else //The user hasn't send the form
        {
            DoSignup(NULL, NULL);
        }
    }
    else //If there's no saved session and the user hasen't click on signup, he go to the login page
    {
        if(isset($_POST['Login'])) //The user has send a form for login
        {
            DoLogin($_POST['PseudoForm'], $_POST['PasswordForm']);
        }
        else //The user hasn't send the form
        {
            DoLogin(NULL, NULL);
        }
    }
}
catch(Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}
