<?php
  $generatedate = new Datetime("now");
  $uniqueimage = $generatedate->format('U') . ".jpg"; 
  //echo $uniqueimage;
  $uniqueimage = "images/" . $uniqueimage;
  
  include_once("uploadresizeimage.php");
  $resize = new UploadResizeImage($_FILES["upload"]);
  $resize->targetWidth = 1200;
  $resize->targetHeight = 1200;
  $resize->mode = "cover";
  $resize->save($uniqueimage); //eg. upload/photo.jpg
  
  header('Location:' . $uniqueimage);
?>
