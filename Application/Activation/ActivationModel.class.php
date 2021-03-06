<?php
require_once('Application/DatabaseManager.class.php');
require_once('Application/HigifyConfig.class.php');
require_once('Application/User/UserController.class.php');
require_once('PHPMailer/PHPMailerAutoload.php');
require_once('ActivationType.class.php');

class ActivationModel
{
    /**
     * Generates a key assigned to a userID
     * @param integer $userID The users ID
     * @param string  $type   The key type
     * @return string The activation key
     */
    public static function createKey($userID, $type)
    {
        $newKey = self::generateKey(30);
        
        $pdo = DatabaseManager::getDB();
        $query = $pdo->prepare('INSERT INTO ActivationToken (userID, hash, type) VALUES (:userID, :hash, :type)');
        $query->bindParam('userID', $userID);
        $query->bindParam('hash', $newKey);
        $query->bindParam('type', $type);
        $query->execute();
        
        return $newKey;
    }
    
    /**
     * Generates a random stirng
     * @param integer $length  The length of the output string
     * @param string  $charset Which strings can be in the random string
     * @return string A random string
     */
    private static function generateKey($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $str = '';
        $count = strlen($charset);
        
        while ($length--)
            $str .= $charset[mt_rand(0, $count-1)];
        
        return $str;
    }
    
    /**
     * Checks if a key exists
     * @param string  $key             The key to validate
     * @param boolean $destroyIfExists If the key should be destroyed if it exists, 
     *                                 also performs the activation if this is set to true
     * @return mixed The token type if key was found otherwise false
     */
    public static function keyExists($key, $destroyIfExists)
    {
        $pdo = DatabaseManager::getDB();
        $query = $pdo->prepare('SELECT type, userID, tokenID FROM ActivationToken WHERE hash = :key');
        $query->bindParam(':key', $key);
        $query->execute();
        
        if ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            if ($destroyIfExists)
            {
                $query = $pdo->prepare('DELETE FROM ActivationToken WHERE hash = :key AND tokenID = :id');
                $query->bindParam(':key', $key);
                $query->bindParam(':id', $row['tokenID']);
                $query->execute();
                
                if ($row['type'] == ActivationType::EMAIL)
                {
                    UserController::activateUserEmail($row['userID']);
                }
                else
                {
                    $user = UserModel::getUserByID($row['userID']);
                    $newPassword = self::generateKey(10);
                    $emailContent = UserController::notifyPasswordChange($user, $newPassword);
                    self::sendEmail($user->getEmail(), $emailContent);
                }
            }
            
            return $row['type'];
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Sends an email
     * @param string $receiver The receiver of the email
     * @param string $content  The content of the email
     * @param string $subject  The subject of the email
     */
    public static function sendEmail($receiver, $content, $subject)
    {
        $mail = new PHPMailer();

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = HigifyConfig::MAIL_HOST;                // Specify main and backup server
        $mail->SMTPAuth = HigifyConfig::MAIL_SMTP_AUTH;                               // Enable SMTP authentication
        $mail->Username = HigifyConfig::MAIL_USERNAME;         // SMTP username
        $mail->Password = HigifyConfig::MAIL_PASSWORD;         // SMTP password
        $mail->Port = HigifyConfig::MAIL_PORT;

        $mail->From = HigifyConfig::MAIL_TITLE_FROM;
        $mail->FromName = HigifyConfig::MAIL_TITLE_FROM_NAME;
        
        $mail->addAddress($receiver);                         // Name is optional

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $content;
        
        $mail->send();
    }
}

?>