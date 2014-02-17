<?php
require_once('UserModel.class.php');
$picture = UserModel::fetchProfilePicture(5);
header("Content-type: image/jpeg");
echo $picture;
?>