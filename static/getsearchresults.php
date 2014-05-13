<?php
require_once('Application/User/UserController.class.php');


if (isset($_POST['search']))
{
    $searchString = $_POST['search'];
    $results = UserController::requestSearchResults($searchString);
    
    return "hei på deg";
}
else
    return "hei";

?>