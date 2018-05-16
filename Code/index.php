<?php
session_start();
require('controller/frontend.php');
require('function/function.php');

//error_log(print_r($_POST, 1));

try
{
    if(isset($_SESSION['Pseudo']))
    {
        ListGames();
    }
    elseif(isset($_GET['Signup']))
    {
        if(isset($_POST['Signup']))
        {
            DoSignup($_POST['PseudoForm'], $_POST['PasswordForm']);
        }
        else
        {
            DoSignup(NULL, NULL);
        }
    }
    else
    {
        if(isset($_POST['Login']))
        {
            DoLogin($_POST['PseudoForm'], $_POST['PasswordForm']);
        }
        else
        {
            DoLogin(NULL, NULL);
        }
    }    
}
catch(Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}