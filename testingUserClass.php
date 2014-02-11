


<!DOCTYPE HTML>
<html>
	<head>

		<title>Higify - Login</title>
	</head>
	<body id="page">

		<div class="pageContainer">
			<div class="centerContainer">
				<form action="testingUserClass.php" method="POST">
				<div class="pageTitle">change password</div>
				<div class="loginContainer">
				
					<label for="username">UserID</label><br/>
					<input class="inputfield" type="text" name="userID"/><br/>
					
				</div>
				<div>
					<input class="loginbtn" type="submit" value="Submit">
				</div>
				</form>
			</div>
		</div>
	</body>
</html>
<?php
session_start();

require_once 'SessionController.class.php';
require_once "user/UserModel.class.php";

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
    
}





?>

          
