php resize the image file

$resize = new UploadResizeImage($_FILES["upload"]);\n
$resize->setProperty("width", 300);\n
$resize->setProperty("height", 200);\n
$resize->setProperty("model", "large");\n
$resize->execute();\n
$resize->save("path"); //eg. upload/photo.jpg\n
