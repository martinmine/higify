<?php
require_once "UserModel.php";


$userModel = new UserModel();

// Legger inn Joakim som bruker
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
    echo "POST VAR TOM";

?>