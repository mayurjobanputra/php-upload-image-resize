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
  $resize->targetWidth = 300;
  $resize->targetHeight = 200;
  $resize->mode = "contain";
  $resize->save("full-upload-path"); //eg. upload/photo.jpg
?>
```

### mode:(According to the percentage of targetWidth and targetHeight set)<br>
default: cover<br>
cover: It will crop the image, but there will be no white or transparent background color.<br>
contain: No crop, but white or transparent background color<br>
byWidth: zoom according to width<br>
byHeight: Scale according to height<br>
autoHeight: Scale according to width, but the height is not targetHeight, but the height based on the percentage of width<br>

### property:
Default: According the width resize image<br>
If provide targetHeight value, it will have cropped effect

## If you upload no result, try to change php.ini file settings as below.

- upload_max_filesize = 64M
- post_max_size = 64M
- max_execution_time = 300
- memory_limit = 256M
