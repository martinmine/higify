<?php
require_once('ActivationType.class.php');
require_once('PasswordActivationView.class.php');
require_once('EmailActivationView.class.php');

class ActivationViewFactory
{
    /**
     * Gets the right IActivationView for the type
     * @param string                    $type The type we want, valid values defined in ActivationType.class.php
     * @throws InvalidArgumentException       When $type is of an unknown/unsupported value
     * @return IActivationView                the view for the type
     */
    public static function getView($type)
    {
        switch ($type)
        {
            case ActivationType::EMAIL:
                return new EmailActivationView();
            case ActivationType::PASSWORD:
                return new PasswordActivationView();
            default:
                throw new InvalidArgumentException("$type is an invalid argument");
        }
    }
}
?>