<?php 

class UploadResizeImage{
    protected $fileType;
    protected $originalWidth;
    protected $originalHeight;
    protected $originalImage;
    protected $resizeImage;
    protected $targetWidth = 768;
    protected $targetHeight = 0;

	public function __construct($file){

        $this->fileType = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (!in_array($this->fileType, array('jpg', 'jpeg', 'png', 'peng'))) {
            echo "only accept format: jpg, jpeg, png, peng";
            exit;
        }

      $tmpName = $file["tmp_name"];

      list($this->originalWidth, $this->originalHeight) = getimagesize($tmpName);

		if ($this->fileType == 'jpeg' || $this->fileType == 'jpg') {
			$this->originalImage = imagecreatefromjpeg($tmpName);
		} else  if ($this->fileType == 'png'){
			$this->originalImage = imagecreatefrompng($tmpName);
		}
	}

	public function __set($key, $value) {
		if (isset($this->$key)){
			$this->$key = $value;
		}
    }

    public function __get($key){
        if (isset($this->$key)){
            return $this->$key;
        }
    }
    
	public function save($fullPathFileName){
        
        if ($this->targetHeight != 0) {
            $this->crop();
        } else {
            $this->auto();
        }

	    switch($this->fileType) {
        case 'peng':
        case 'png':
	        imagepng($this->resizeImage, $fullPathFileName);
        break;
        default:
            imagejpeg($this->resizeImage, $fullPathFileName, 100);
        break;
	    }
	} 
    
    //Change the size with the width
	protected function auto() { 
    $activeWidth = $this->targetWidth;
		$activeHeight = $this->originalHeight * $activeWidth / $this->originalWidth;
		$this->targetHeight = $activeHeight;

    $this->resizeImage = imagecreatetruecolor($this->targetWidth, $this->targetHeight);
        $bgcolor = imagecolorallocatealpha($this->resizeImage, 255, 255, 255, 0);
        imagefill($this->resizeImage, 0, 0, $bgcolor);
		imagecopyresampled($this->resizeImage, $this->originalImage, 0, 0, 0, 0, $activeWidth, $activeHeight, $this->originalWidth, $this->originalHeight);
	}
    
    //Change the size with width and height
    protected function crop(){
		$heightRatio = $this->targetHeight / $this->originalHeight;
        $widthRatio = $this->targetWidth / $this->originalWidth;
        
		if ($heightRatio > $widthRatio) {
            $activeHeight = $this->targetHeight;
            $activeWidth =  $this->originalWidth * $activeHeight / $this->originalHeight;
            $trim = ($this->targetWidth - $activeWidth)/2;

            $this->resizeImage = imagecreatetruecolor($this->targetWidth, $this->targetHeight);
            $bgcolor = imagecolorallocatealpha($this->resizeImage, 255, 255, 255, 0);
            imagefill($this->resizeImage, 0, 0, $bgcolor);
            imagecopyresampled($this->resizeImage, $this->originalImage, $trim, 0, 0, 0, $activeWidth, $activeHeight, $this->originalWidth, $this->originalHeight);
		} else {
            $activeWidth = $this->targetWidth;
            $activeHeight = $this->originalHeight * $activeWidth / $this->originalWidth;
            $trim = ($this->targetHeight - $activeHeight)/2;

            $this->resizeImage = imagecreatetruecolor($this->targetWidth, $this->targetHeight);            
            $bgcolor = imagecolorallocatealpha($this->resizeImage, 255, 255, 255, 0);
            imagefill($this->resizeImage, 0, 0, $bgcolor);
            imagecopyresampled($this->resizeImage, $this->originalImage, 0, $trim, 0, 0, $activeWidth, $activeHeight, $this->originalWidth, $this->originalHeight);
		}
	}
}
?>
