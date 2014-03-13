<?php
require_once('Application/Activation/ActivationController.class.php');
require_once('Application/Activation/ActivationType.class.php');
require_once('Application/User/UserController.class.php');

if (isset($_GET['key']))
{
    $type = ActivationController::validateActivationKey($_GET['key'], true);
    if ($type === false)    // Invalid key
    {
        header('Location: login.php?invalidkey');
        exit;
    }
    else
    {
        if ($type == ActivationType::EMAIL)   // This key was for an email
        {
            header('Location: login.php?activated');
            exit;
        }
        else if ($type == ActivationType::PASSWORD)   // This key was for a password
        {
            header('Location: login.php?passwordchanged');
            exit;
        }
        else 
            die('Unknown type: ' . $type);
    }
}

header('Location: index.php');
?>