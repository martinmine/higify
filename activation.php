<?php
require_once('Activation/ActivationController.class.php');
require_once('Activation/ActivationType.class.php');
require_once('UserController.class.php');

if (isset($_GET['key']))
{
    $type = ActivationController::validateActivationKey($_GET['key'], true);
    if ($type === false)    // Invalid key
    {
        header('Location: login.php?invalidkey');
    }
    else
    {
        if ($type == ActivationType::EMAIL)   // This key was for an email
            header('Location: login.php?activated');
        else    // This key was for a password
            header('Location: login.php?passwordsent');
    }
}
die('key not set');
header('Location: index.php');
?>