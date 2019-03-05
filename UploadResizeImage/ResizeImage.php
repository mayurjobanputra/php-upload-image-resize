<?php 
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');

class ResizeImage{
	protected $width = 0;
	protected $height = 0;
	protected $model = 'small';
	//width, height, small, large, fixed, none;
	//如果要設定為fixed,width必須等於height
	protected $verticalAlign = 'center';
	protected $horizontalAlign = 'center';
	protected $backgroundColor = "white";
	// white, black, transparent
	protected $fileTypes = array('jpg','jpeg', 'png','gif');
	protected $fileUpload = "";
	protected $fileWidth = 0;
	protected $fileHeight = 0;
	protected $type = "";
	protected $resize_image;

	public function setProperty($property, $value) {
		if(isset($this->$property)){
			$this->$property = $value;
		} else{
			echo '^_^" This property is not available';
		}
	}
	
	public function getProperty($property) {
		if(isset($this->$property)){
			$this->$property = $value;
		} else{
			echo '^_^" This property is not available';
		}
	}

	public function __construct($original_image){
		$this->original_image = $original_image;
		$this->type = explode(".", $original_image);
		$this->type = $this->type[1];
		if (!in_array($this->type, $this->fileTypes)) {
            echo "file type Error!!";
            exit;
		}
		$this->setup();
	}

	public function setup(){
		list($this->fileWidth, $this->fileHeight) = getimagesize($this->original_image);

		if ($this->type == 'jpeg' || $this->type == 'jpg') {
			$this->original_image = imagecreatefromjpeg($this->original_image);
		} else  if ($this->type == 'png'){
			$this->original_image = imagecreatefrompng($this->original_image);
		} else if ($this->type == 'gif'){
			$this->original_image = imagecreatefromgif($this->original_image);
		}
	}

	public function get_resize_image(){
		return $this->resize_image;
	}

	public function save($fullPathFileName){
	    switch($this->type) {
	      case 'jpeg':
	        imagejpeg($this->resize_image, $fullPathFileName, 100);
	      break;
	      case 'jpg':
	        imagejpeg($this->resize_image, $fullPathFileName, 100);
	      break;
	      case 'png':
	        imagepng($this->resize_image, $fullPathFileName);
	      break;
	      case 'gif':
	        imagegif($this->resize_image, $fullPathFileName);
	      break;
	    }
	} 
	
	public function execute(){
		switch ($this->model) {
			case 'width':
				$this->scaleWidthModel();
			break;
			case 'height':
				$this->scaleHeightModel();
			break;
			case 'small':
				$this->scaleSmallModel();
			break;
			case 'large':
				$this->scaleLargeModel();
			break;
			case 'fixed':
				$this->scaleFixedModel();
			break;
			default:
				$this->scaleNoneModel();	
		}
	}

	protected function scaleFixedModel(){
		$height_ratio = $this->height / $this->fileHeight;
    	$width_ratio = $this->width / $this->fileWidth;
		if ($height_ratio > $width_ratio) {
			$activeWidth = $this->width;
			$activeHeight = $this->fileHeight * $activeWidth / $this->fileWidth;
			$this->resize_image = imagecreatetruecolor($activeWidth, $activeHeight);
			imagecopyresampled($this->resize_image, $this->original_image, 0, 0, 0, 0,  $activeWidth, $activeHeight, $this->fileWidth, $this->fileHeight);
		} else {
			$activeHeight = $this->height;
			$activeWidth = $this->fileWidth * $activeHeight / $this->fileHeight;
			$this->resize_image = imagecreatetruecolor($activeWidth, $activeHeight);
			imagecopyresampled($this->resize_image, $this->original_image, 0, 0, 0, 0,  $activeWidth, $activeHeight, $this->fileWidth, $this->fileHeight);
		}
	}
	
	protected function getBackgroundColor(){
		switch($this->backgroundColor){
			case 'transparent':
				imagesavealpha($this->resize_image, true);
				$color = imagecolorallocatealpha($this->resize_image, 0, 0, 0, 127);
				imagefill($this->resize_image, 0, 0, $color);
			break;
			case 'black':
				$backgroundColor = imagecolorallocate($this->resize_image, 0, 0, 0);
				imagefill($this->resize_image, 0, 0, $backgroundColor);
			break;
			default://default is white
				$backgroundColor = imagecolorallocate($this->resize_image, 255, 255, 255);
				imagefill($this->resize_image, 0, 0, $backgroundColor);
		}
	}

	protected function scaleWidthModel() { //把image根據width縮放
		$activeWidth = $this->width;
		$activeHeight = $this->fileHeight * $activeWidth / $this->fileWidth;
		
		if($this->verticalAlign == 'top'){
			$trimTop = 0;
		} else if($this->verticalAlign == 'bottom'){
			$trimTop = $this->height - $activeHeight;
		} else {
			$trimTop = ($this->height - $activeHeight)/2;
		}

		$this->resize_image = imagecreatetruecolor($this->width, $this->height);
		$this->getBackgroundColor();
		
		imagecopyresampled($this->resize_image, $this->original_image, 0, $trimTop, 0, 0, $activeWidth, $activeHeight, $this->fileWidth, $this->fileHeight);
	}
	
	protected function scaleHeightModel(){
		$activeHeight = $this->height;
		$activeWidth =  $this->fileWidth * $activeHeight / $this->fileHeight;
		
		if($this->horizontalAlign == 'left'){
			$trimLeft = 0;
		} else  if ($this->horizontalAlign == 'right') {
			$trimLeft =  $this->width - $activeWidth;
		} else{
			$trimLeft = ($this->width - $activeWidth)/2;
		}

		$this->resize_image = imagecreatetruecolor($this->width, $this->height);
		$this->getBackgroundColor();
		imagecopyresampled($this->resize_image, $this->original_image, $trimLeft, 0, 0, 0, $activeWidth, $activeHeight, $this->fileWidth, $this->fileHeight);
	}
	
	private function scaleSmallModel(){
		$height_ratio = $this->height / $this->fileHeight;
		$width_ratio = $this->width / $this->fileWidth;
		if ($width_ratio > $height_ratio) {
			$this->scaleHeightModel();
		} else {
			$this->scaleWidthModel();
		}
	}
	
	protected function scaleLargeModel(){
		$height_ratio = $this->height / $this->fileHeight;
    	$width_ratio = $this->width / $this->fileWidth;
		if ($height_ratio > $width_ratio) {
			$this->scaleHeightModel();
		} else {
			$this->scaleWidthModel();
		}
	}
	
	protected function scaleNoneModel(){
		$activeWidth = $this->width;
		$activeHeight = $this->height;
		$this->resize_image = imagecreatetruecolor($this->width, $this->height);
		$this->getBackgroundColor();
		imagecopyresampled($this->resize_image, $this->original_image, 0, 0, 0, 0, $activeWidth, $activeHeight, $this->fileWidth, $this->fileHeight);
	}
}
?>