# php resize the image file

include_once("UploadResizeImage.php");

$resize = new UploadResizeImage($_FILES["upload"]);

$resize->setProperty("width", 300);

$resize->setProperty("height", 200);

$resize->setProperty("model", "large");

$resize->execute();

$resize->save("full-upload-path"); //eg. upload/photo.jpg
