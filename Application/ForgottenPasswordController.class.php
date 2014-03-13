<?php
require_once('Template/IPageController.interface.php');
require_once('Session/SessionController.class.php');
require_once('Recaptcha/recaptchalib.php');
require_once('Activation/ActivationController.class.php');
require_once('Activation/ActivationType.class.php');
require_once('ErrorMessageView.class.php');

class ForgottenPasswordController implements IPageController
{
    public function onDisplay()
    {
        $user = SessionController::acquireSession(true);    // Send the user home if he is logged in
        $vals = array();
        
        $vals['RECAPTCHA_PUBLIC_KEY'] = HigifyConfig::RECAPTCHA_PUBLIC_KEY;
        
        if ($user !== NULL)
        {
            header('Location: index.php');
            exit;
        }
        
        if (isset($_POST['email']))
        {
            $validValues = true;
            $captchaResponse = recaptcha_check_answer(HigifyConfig::RECAPTCHA_PRIVATE_KEY, $_SERVER['REMOTE_ADDR'], // Verify the security code
                                       $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            
            if (!$captchaResponse->is_valid) 
            {
                $vals['ERROR_CAPTCHA'] = new ErrorMessageView('Invalid security code');
                return $vals; // Exit
            }
            
            $user = UserController::requestUserByEmail($_POST['email']);
            if ($user === NULL)
            {
                $vals['ERROR_EMAIL'] = new ErrorMessageView('There is no registered user with this email address.');
            }
            else
            {
                ActivationController::generateActivationKey($user->getUserID(), $user->getEmail(), ActivationType::PASSWORD);
                header('Location: login.php?passwordsent');
                exit;
            }
        }
        
        return $vals;
    }
}
?>