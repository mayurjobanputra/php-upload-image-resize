# php-image-upload-resize
php resize the image file

$resize = new UploadResizeImage($_FILES["upload"]);
$resize->setProperty("width", 300);
$resize->setProperty("height", 200);
$resize->setProperty("model", "large");
$resize->execute();
$resize->save("path"); //eg. upload/photo.jpg
