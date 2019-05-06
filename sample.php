<?php
	if (isset($_POST["author"])) {
		include_once "UploadResizeImage.php";
		$file = $_FILES["screenshot"];
		$resize = new UploadResizeImage($file);
		$resize->targetWidth = 1200;
		$resize->targetHeight = 600;
		$resize->mode = "autoHeight";
		$resize->save("testing2.jpg");
		header('Content-Type: image/jpeg');
		imagejpeg($resize->resizeImage);
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
	<form name="form1" method="post" enctype="multipart/form-data">
		<input type="file" name="screenshot"/>
		<input type="hidden" value="joe" name="author" />
		<input type="submit" value="sumbit" />
	</form>
</body>
</html>