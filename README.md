# PHP Resize Upload Image File

UploadResizeImage - is the free and make upload image file resize easily

form.html
```
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
```

upload.php
```
<?php
  include_once("UploadResizeImage.php");
  $resize = new UploadResizeImage($_FILES["upload"]);
  $resize->setProperty("width", 300);
  $resize->setProperty("height", 200);
  $resize->setProperty("model", "large");
  $resize->execute();
  $resize->save("full-upload-path"); //eg. upload/photo.jpg
?>
```
