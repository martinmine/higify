<?php
require_once('ActivationModel.class.php');
require_once('ActivationViewFactory.class.php');

class ActivationController
{
    /**
     * Validates an activation key
     * @param string  $key            The key
     * @param boolean $destroyIfFound Destroy the key if it was found
     * @return boolean True if the key is valid, otherwise the type of the activation key
     */
    public static function validateActivationKey($key, $destroyIfFound = false)
    {
        return ActivationModel::keyExists($key, $destroyIfFound);
    }
    
    /**
     * Creates a key and sends a mail to the user which contains this key.
     * @param integer $userID The user ID
     * @param string  $email  The email address where the email shall be sent
     * @param string  $type   A valid activation type
     * @return string A new activation key/token
     */
    public static function generateActivationKey($userID, $email, $type)
    {
        $key = ActivationModel::createKey($userID, $type);
        $view = ActivationViewFactory::getView($type);
        $emailContent = $view->getEmailContent($key);
        $emailSubject = $view->getEmailSubject();
        
        ActivationModel::sendEmail($email, $emailContent, $emailSubject);
        
        return $key;
    }
}

?>