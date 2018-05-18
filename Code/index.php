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
            GoSettings();
        }
        elseif(isset($_POST['IdUpdateSettings'])) //The admin changed one value in the database
        {
            DoUpdateSettings($_POST['ValueIntForm'], $_POST['IdUpdateSettings']);
        }
        elseif(isset($_POST['IdJoinGame'])) //The user want to join a game
        {
            GoGame($_SESSION['Pseudo'], $_POST['IdJoinGame']);
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
