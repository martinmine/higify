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

          
