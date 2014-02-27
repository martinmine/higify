<?php
require_once('Template/IPageController.interface.php');
require_once('SessionController.class.php');
require_once('UserModel.class.php');
require_once('ErrorMessageView.class.php');
require_once('Recaptcha/recaptchalib.php');
require_once('HigifyConfig.class.php');

class RegistrationController implements IPageController
{
    public function onDisplay()
    {
        $user = SessionController::acquireSession(true);    // Send the user home if he is logged in
        $vals = array();
        
        $mostUsedPasswords = HigifyConfig::$BAD_PASSWORDS;
        
        $vals['RECAPTCHA_PUBLIC_KEY'] = HigifyConfig::RECAPTCHA_PUBLIC_KEY;
        
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
            
            $captchaResponse = recaptcha_check_answer(HigifyConfig::RECAPTCHA_PRIVATE_KEY, $_SERVER['REMOTE_ADDR'], // Verify the security code
                                       $_POST["recaptcha_challenge_field"], $captcha);
            
            if (strlen($username) == 0) // No username entered
            {
                $vals['ERROR_USR'] = new ErrorMessageView('Please enter a username');
            }
            else if (UserController::userExists($username)) // User already exists TODO: move userexists to UserController
            {
                $vals['ERROR_USR'] = new ErrorMessageView('A user with this username already exists. Try another one.');
                $_POST['username'] = '';
            }
            
            if (strlen($password) == 0) // No password entered
            {
                $vals['ERROR_PSW'] = new ErrorMessageView('Please enter a password');
            }
            else if (in_array(strtolower($password), $mostUsedPasswords))
            {
                $vals['ERROR_PSW'] = new ErrorMessageView('You are not allowed to use the same password as the system administrator!');
            }
            else if (strlen($password) < 7) // Not secure enough password
            {
                $vals['ERROR_PSW'] = new ErrorMessageView('Enter a password longer than six characters');
            }
            
            if ($password != $passwordVerification) // Passwords didn't match
            {
                $vals['ERROR_PSWCONFIRM'] = new ErrorMessageView('The passwords you entered are not the same');
            }
            
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) // Invalid email
            {
                $vals['ERROR_EMAIL'] = new ErrorMessageView('Please specify a valid email address');
            }
            else if (UserController::requestUserByEmail($email) !== NULL) // A user already exists with this email
            {
                $vals['ERROR_EMAIL'] = new ErrorMessageView('An user with this email already exists');
            }
            
            if (strlen($captcha) == 0)
            {
                $vals['ERROR_CAPTCHA'] = new ErrorMessageView('Please enter the two words in the image above');
            }
            else if (!$captchaResponse->is_valid) // Invalid captcha
            {
                $vals['ERROR_CAPTCHA'] = new ErrorMessageView('Invalid security code');
            }
           
            if (!isset($vals['ERROR_CAPTCHA']))
            {
                UserController::registerUser($username, $password, $email);
                header('Location: login.php?registered');
            }
        }
        
        return $vals;
    }
}
?>