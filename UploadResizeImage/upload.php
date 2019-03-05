<?php
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
?>