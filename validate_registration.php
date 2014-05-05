<?php
require_once('Application/RegistrationController.class.php');

header('Content-type: application/json');

//validateRegistration($username, $password, $passwordVerification, $email, $captcha)
$validation = RegistrationController::validateRegistration($_POST['username'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'], $_POST['recaptcha_response_field']);

$i = 0;

$count = count($validation);

echo '{';

foreach ($validation as $name => $template)
{
    echo '"' . $name . '":';
    echo '"';
    echo $template;
    echo '"';
    
    if (++$i != $count) //If it is not the last one 
    {
       echo ",\n";
    }
}

echo '}';



?>