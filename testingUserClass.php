<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8" content="image/jpeg"/>
	</head>
<body>

<form action="testingUserClass.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
<?php
session_start();


require_once "UserController.class.php";
/*
UserController::loginUser($_POST['username']);


$userModel = new UserModel();


if($test = $userModel->registerUser('Joakim','12345','jjoereng@gmail.com','0','0'))
{
    if($test)
    {
        echo "bruker registrert</br>";
    }
}
else
    echo "denne brukeren er registrert tidligere</br>";


if(isset($_POST['username']) && isset($_POST['password']))
{
    $user = $userModel->getUser($_POST['username'], $_POST['password']);
    if($user !== NULL)
    {
       $user->display();
    }
    else
        echo "Login failed!";
}
else
    echo "POST VAR TOM FOR USERNAME OG PW";

print_r($_POST);
if(isset($_POST['userID']) && isset($_POST['currentPassword']) && isset($_POST['newPassword']))
{
     if($userModel->newPassword($_POST['userID'], $_POST['currentPassword'],$_POST['newPassword']))
     echo "sucess!";
     
     else
         echo "noe gikk galt i newPassword";
}
else 
    echo "FORM ER TOM FOR PW";


if(isset($_POST['userID']))
{
    $user = $userModel->getUserByID($_POST['userID']);
    if($user)
    {
        $user->display();
        echo "getUserByID SUCCESS!111";
    }
    else
        echo "getUserByID FAILED!";
    
}*/

print_r($_POST);
print_r($_FILES);

echo count($_FILES);
if(count($_FILES) > 0)
{
    if ($_FILES['file']["error"] > 0)
    {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Stored in: " . $_FILES["file"]["tmp_name"];
    }

    if(isset($_FILES['file']))
    {
        UserController::requestPictureSubmit(5,$_FILES['file']);
      
    
        
    }
}


?>

          
