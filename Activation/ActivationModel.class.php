<?php
require_once('../DatabaseManager.class.php');
require_once('PHPMailer/PHPMailerAutoload.php');
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
     * @param boolean $destroyIfExists If the key should be destroyed if it exists
     * @return boolean True if key was found
     */
    public static function keyExists($key, $destroyIfExists)
    {
        $pdo = DatabaseManager::getDB();
        $query = $pdo->prepare('SELECT tokenID FROM ActivationToken WHERE hash = :key');
        $query->bindParam(':key', $key);
        $query->execute();
        
        if ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            $query = $pdo->prepare('DELETE FROM FROM ActivationToken WHERE hash = :key AND tokenID = :id');
            $query->bindParam(':key', $key);
            $query->bindParam(':id', $row['tokenID']);
            $query->execute();
            return false;
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
     */
    public static function sendEmail($receiver, $content)
    {
        $mail = new PHPMailer();

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.dongsecurity.com';                // Specify main and backup server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'activation@obbahhost.com';         // SMTP username
        $mail->Password = 'Vtft32XRp8FVZQGvETu4vpmM';         // SMTP password
        $mail->Port = 94;

        $mail->From = 'activation@obbahhost.com';
        $mail->FromName = 'The Higify Team';
        $mail->addAddress($receiver);                         // Name is optional

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Activation';
        $mail->Body    = $content;
        
        $mail->send();
    }
}

?>