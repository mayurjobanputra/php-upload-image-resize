<?php 
	include_once("ResizeImage.php");

	class UploadResizeImage extends ResizeImage{
		public function __construct($file){
			$this->original_image = $file["tmp_name"];
			$this->file_name = $file["name"];
			$this->type = pathinfo($this->file_name, PATHINFO_EXTENSION);
			if (!in_array($this->type, $this->fileTypes)) {
				echo "file type Error!!";
				exit;
			}
			$this->setup();
		}
	}
?>