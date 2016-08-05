<?php
class ThumbnailImage
{
	private $image;
	//not applicable to gif or png
	private $quality = 100;
	private $mimetype;
	private $imageproperties = array();
	private $initialfilesize;
	
	public function __construct($file, $thumbnailsize = 100){
		// check file
		is_file($file) or die("File: $file doesn't exist.");
		$this->initialfilesize = filesize($file);
		$this->imageproperties = getimagesize($file) or die("Incorrect file_type.");
		// new function image_type_to_mime_type
		$this->mimetype = image_type_to_mime_type($this->imageproperties[2]);
		// create image
		switch($this->imageproperties[2]){
			case IMAGETYPE_JPEG:
				$this->image = imagecreatefromJPEG($file);
				break;
			case IMAGETYPE_GIF:
				$this->image = imagecreatefromGIF($file);
				break;
			case IMAGETYPE_PNG:
				$this->image = imagecreatefromPNG($file);
				break;
			default:
				die("Failed to create the image.");
		}
		
		$this->createThumb($thumbnailsize);
	}
	
	public function __destruct(){
		if(isset($this->image)){
			imagedestroy($this->image);
		}
	}
	
	// This method send the images in the browser
	public function getImage(){
		header("Content-type: $this->mimetype");
		switch($this->imageproperties[2]){
			case IMAGETYPE_JPEG:
				imagejpeg($this->image, NULL, $this->quality);
				break;
			case IMAGETYPE_GIF:
				imagegif($this->image);
				break;
			case IMAGETYPE_PNG:
				imagepng($this->image);
				break;
			default:
				die("Failed to create the image.");
		}
	}
	
	public function getMimeType(){
		return $this->mimetype;
	}
	
	// We set the quality of the image
	// Make sure that the quality is be between 1 and 100
	public function setQuality($quality){
		if($quality > 100 || $quality < 1){
			$qaulity = 75;
			if($this->imageproperties[2] == IMAGETYPE_JPEG || $this->imageproperties[2] == IMAGETYPE_PNG){
				$this->qaulity = $quality;
			}
		}
	}
	
	// The getter method that returns the quality of the images
	public function getQuality(){
		$quality = null;
		if($this->imageproperties[2] == IMAGETYPE_JPEG || $this->imageproperties[2] == IMAGETYPE_PNG){
			$quality = $this->quality;
		}
		return $quality;
	}
	
	public function getInitialFileSize(){
		return $this->initialfilesize;
	}
	
	// method that determines image orientation
	private function createThumb($thumbnailsize){
		// array elements for width and height
		$srcW = $this->imageproperties[0];
		$srcH = $this->imageproperties[1];
		// only adjust if larger than max
		if($srcW > $thumbnailsize || $srcH > $thumbnailsize){
			$reduction = $this->calculateReduction($thumbnailsize);
			// get proportions
			$desW = $srcW / $reduction;
			$desH = $srcH / $reduction;
			$copy = imagecreatetruecolor($desW, $desH);
			imagecopyresampled($copy, $this->image, 0, 0, 0, 0, $desW, $desH, $srcW, $srcH ) or die("Image copy failed.");
			// destroy original image
			imagedestroy($this->image);
			$this->image = $copy;
		}
	}
	
	// This method finds out the orientation of the image and calculates the rate of reduction
	private function calculateReduction($thumbnailsize){
		$srcW = $this->imageproperties[0];
		$srcH = $this->imageproperties[1];
		// adjust the orientation
		if($srcW < $srcH){
			$reduction = round($srcH / $thumbnailsize);
		}else{
			$reduction = round($srcW / $thumbnailsize);
		}
		return $reduction;
	}
	
} // end class