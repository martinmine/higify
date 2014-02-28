<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8" content="image/jpeg"/>
		<style>
		div.upload {
    width: 157px;
    height: 57px;
    background: url('Static/attachment.png');
    overflow: hidden;
}

div.upload input {
    display: block !important;
    width: 157px !important;
    height: 57px !important;
    opacity: 0 !important;
    overflow: hidden !important;
}
	</style>
	</head>
<body>

<form action="testingUserClass.php" method="post"
enctype="multipart/form-data">
<div class="upload">
	<input type="file" name="file" id="file"><br>
</div>
<input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
<?php
session_start();


require_once "UserController.class.php";
require_once "NoteController.class.php";


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
        if(isset($_FILES['file']))
        {
            NoteController::submitAttatchment(1,$_FILES['file']);
        }
    }


}


?>

          
