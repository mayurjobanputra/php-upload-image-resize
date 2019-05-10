<?php 

class UploadResizeImage{
    protected $fileType;
    protected $originalWidth;
    protected $originalHeight;
    protected $originalImage;
    protected $resizeImage;
    protected $targetWidth = 768;
	protected $targetHeight = 0;
	protected $mode = "cover";
	/* 
		mode:(根據設定的targetWidth和targetHeight的百份比)
			cover: 會crop圖,但不會有白色或透明的背境色出現
			contain: 不會crop圖,但會出現白色或透明的背境色
			byWidth: 根據width做縮放
			byHeight: 根據height做縮放
			autoHeight: 根據width做縮放, 但高度不是targetHeight, 而是根據width的百份比而得的高度
	*/

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
		switch ($this->mode){
			case "contain":
				$this->contain();
			break;
			case "cover":
				$this->cover();
			break;
			case "byWidth":
				$this->byWidth();
			break;
			case "byHeight":
				$this->byHeight();
			break;
			case "autoHeight":
				$this->autoHeight();
			break;
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
        
    //Change the size with width and height
    protected function contain(){
		$heightRatio = $this->targetHeight / $this->originalHeight;
        $widthRatio = $this->targetWidth / $this->originalWidth;
		if ($widthRatio > $heightRatio) {
			$this->byHeight();
		} else {
			$this->byWidth();
		}
	}

	public function cover(){
		$heightRatio = $this->targetHeight / $this->originalHeight;
        $widthRatio = $this->targetWidth / $this->originalWidth;
		if ($heightRatio > $widthRatio) {
			$this->byHeight();
		} else {
			$this->byWidth();
		}
	}

	//Change the size with the width
	protected function autoHeight() { 
		$activeWidth = $this->targetWidth;
		$activeHeight = $this->originalHeight * $activeWidth / $this->originalWidth;
		$this->targetHeight = $activeHeight;

		$this->resizeImage = imagecreatetruecolor($this->targetWidth, $this->targetHeight);
		imagealphablending($this->resizeImage, false);
		imagesavealpha($this->resizeImage,true);
		$transparency = imagecolorallocatealpha($this->resizeImage, 255, 255, 255, 127);
		imagefilledrectangle($this->resizeImage, 0, 0, $this->targetWidth, $this->targetWidth, $transparency);

		/* $bgcolor = imagecolorallocatealpha($this->resizeImage, 255, 255, 255, 0);
		imagefill($this->resizeImage, 0, 0, $bgcolor); */

		imagecopyresampled($this->resizeImage, $this->originalImage, 0, 0, 0, 0, $activeWidth, $activeHeight, $this->originalWidth, $this->originalHeight);
	}
	
	protected function byHeight(){
		$activeHeight = $this->targetHeight;
		$activeWidth =  $this->originalWidth * $activeHeight / $this->originalHeight;
		$trim = ($this->targetWidth - $activeWidth)/2;

		$this->resizeImage = imagecreatetruecolor($this->targetWidth, $this->targetHeight);
		imagealphablending($this->resizeImage, false);
		imagesavealpha($this->resizeImage,true);
		$transparency = imagecolorallocatealpha($this->resizeImage, 255, 255, 255, 127);
		imagefilledrectangle($this->resizeImage, 0, 0, $this->targetWidth, $this->targetWidth, $transparency);

		//$bgcolor = imagecolorallocatealpha($this->resizeImage, 255, 255, 255, 0);
		//imagefill($this->resizeImage, 0, 0, $bgcolor);
		imagecopyresampled($this->resizeImage, $this->originalImage, $trim, 0, 0, 0, $activeWidth, $activeHeight, $this->originalWidth, $this->originalHeight);
	}

	protected function byWidth(){
		$activeWidth = $this->targetWidth;
		$activeHeight = $this->originalHeight * $activeWidth / $this->originalWidth;
		$trim = ($this->targetHeight - $activeHeight)/2;

		$this->resizeImage = imagecreatetruecolor($this->targetWidth, $this->targetHeight);
		imagealphablending($this->resizeImage, false);
		imagesavealpha($this->resizeImage,true);
		$transparency = imagecolorallocatealpha($this->resizeImage, 255, 255, 255, 127);
		imagefilledrectangle($this->resizeImage, 0, 0, $this->targetWidth, $this->targetWidth, $transparency);           
		/* $bgcolor = imagecolorallocatealpha($this->resizeImage, 255, 255, 255, 0);
		imagefill($this->resizeImage, 0, 0, $bgcolor); */

		imagecopyresampled($this->resizeImage, $this->originalImage, 0, $trim, 0, 0, $activeWidth, $activeHeight, $this->originalWidth, $this->originalHeight);
	}
}
?>
