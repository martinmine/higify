<?php
require_once('Template/IPageController.interface.php');
require_once('SessionController.class.php');
require_once('UserModel.class.php');
require_once('Recaptcha/recaptchalib.php');
require_once('ErrorMessageView.class.php');
require_once('Activation/ActivationController.class.php');
require_once('Activation/ActivationType.class.php');

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
            $user = NULL;
            $captchaResponse = recaptcha_check_answer(HigifyConfig::RECAPTCHA_PRIVATE_KEY, $_SERVER['REMOTE_ADDR'], // Verify the security code
                                       $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            
            if (!$captchaResponse->is_valid) 
            {
                $vals['ERROR_MSG'] = new ErrorMessageView('Invalid security code');
            }
            else if ($user = UserController::requestUserByEmail($_POST['email']) === NULL)
            {
                $vals['ERROR_MSG'] = new ErrorMessageView('There is no registered user with this email address.');
            }
            else
            {
                ActivationController::generateActivationKey($user->getUserID(), $user->getEmail(), ActivationType::PASSWORD);
            }
            
        }
        
        return $vals;
    }
}
?>