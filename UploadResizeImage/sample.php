<?php
	if (isset($_POST["author"])) {
		include_once("UploadResizeImage.php");
		$file = $_FILES["screenshot"];
		$resize = new UploadResizeImage($file);
		$resize->setProperty("width", 300);
		$resize->setProperty("height", 200);
		$resize->setProperty("model", "large");
		$resize->execute();
		$resize->save("testing.jpg");
		header('Content-Type: image/jpeg');
		imagejpeg($resize->get_resize_image());
		die();
	}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>PHP Upload Resize Image</title>
</head>

<body>
	<form method="post" action="upload.php" enctype="multipart/form-data">
		<input type="file" name="upload"/>
		<input type="submit" value="sumbit" />
	</form>
</body>
</html>