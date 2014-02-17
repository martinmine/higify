<?php

require_once('Template/IPageController.interface.php');
require_once('SessionController.class.php');
require_once('UserModel.class.php');
require_once('ErrorMessageView.class.php');
require_once('Recaptcha/recaptchalib.php');

class RegistrationController implements IPageController
{
    const CAPTCHA_PRIVATE_KEY = '6Lfis-4SAAAAANi6ne8PD0-i9U9z8X8PvKnGhJiG';
    
    public function onDisplay()
    {
        $user = SessionController::acquireSession(true);    // Send the user home if he is logged in
        $vals = array();
        $mostUsedPasswords = array('123456', 'password', '12345678', 'qwerty', 'abc123', '123456789', '111111', 
                                    '1234567', 'iloveyou', 'adobe123', '123123', 'admin', '1234567890', 'letmein', 
                                    'photoshop', '1234', 'monkey', 'shadow', 'sunshine', '12345', 'password1', 
                                    'princess', 'azerty', 'trustno1', 'qwerty123', 'asdfg', 'fronter', 'student');
        if ($user !== NULL)
        {
            header('Location: index.php');
            exit;
        }
        
        if (isset($_POST['username']))
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $passwordVerification = $_POST['passwordConfirm'];
            $email = $_POST['email'];
            $captcha = $_POST['recaptcha_response_field'];
            
            $captchaResponse = recaptcha_check_answer(self::CAPTCHA_PRIVATE_KEY, $_SERVER['REMOTE_ADDR'], 
                                       $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            
            $registrationFailure = false;
            
            if (strlen($username) == 0) // No username entered
            {
                $registrationFailure = true;
                $vals['ERROR_USR'] = new ErrorMessageView('Please enter a username');
            }
            else if (UserController::userExists($username)) // User already exists TODO: move userexists to UserController
            {
                $registrationFailure = true;
                $vals['ERROR_USR'] = new ErrorMessageView('A user with this username already exists. Try another one.');
                $_POST['username'] = '';
            }
            
            if (strlen($password) == 0) // No password entered
            {
                $registrationFailure = true;
                $vals['ERROR_PSW'] = new ErrorMessageView('Please enter a password');
            }
            else if (in_array(strtolower($password), $mostUsedPasswords))
            {
                $registrationFailure = true;
                $vals['ERROR_PSW'] = new ErrorMessageView('You are not allowed to use the same password as the system administrator!');
            }
            else if (strlen($password) < 7) // Not secure enough password
            {
                $registrationFailure = true;
                $vals['ERROR_PSW'] = new ErrorMessageView('Enter a password longer than six characters');
            }
            
            if ($password != $passwordVerification) // Passwords didn't match
            {
                $registrationFailure = true;
                $vals['ERROR_PSWCONFIRM'] = new ErrorMessageView('The passwords you entered are not the same');
            }
            
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) // Invalid email
            {
                $registrationFailure = true;
                $vals['ERROR_EMAIL'] = new ErrorMessageView('Please specify a valid email address');
            }
            else if (true) // A user already exists with this email [TODO]
            {
                $registrationFailure = true;
                $vals['ERROR_EMAIL'] = new ErrorMessageView('An user with this email already exists');
            }
            
            if (strlen($captcha) == 0)
            {
                $registrationFailure = true;
                $vals['ERROR_CAPTCHA'] = new ErrorMessageView('Please enter the two words in the image above');
            }
            else if ($captcha) // Invalid captcha
            {
                $registrationFailure = true;
                $vals['ERROR_CAPTCHA'] = new ErrorMessageView('Invalid security code');
            }
            
            if (!$captchaResponse->is_valid) // Something went wrong
            {
                $vals['FORM_USERNAME'] = $username;
                $vals['FORM_EMAIL'] = $email;
            }
            else
            {
                UserController::registerUser($username, $password, $email);
                header('Location: login.php?registered');
            }
        }
        
        return $vals;
    }
}
?>