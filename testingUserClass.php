


<!DOCTYPE HTML>
<html>
	<head>
		<title>Higify - Login</title>
	</head>
	<body id="page">

		<div class="pageContainer">
			<div class="centerContainer">
				<form action="testingUserClass.php" method="POST">
                    <label for="image">Bilde</label><input type="file" name="image" title="Vises sammen med notatblokksider når andre viser dine offentlige notater"><br/>
                    <input class="loginbtn" type="submit" value="Submit">
				</div>
				<div>
					
				</div>
				</form>
			</div>
		</div>
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

if(isset($_FILES['image']))
UserController::requestPictureSubmit(5,$_FILES['image']);


?>

          
