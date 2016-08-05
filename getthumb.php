<?php
// this file will be the src for an img tag
require 'ThumbnailImage.php';

$path = @$_GET["path"]; // We get the path of the file from url path @param
$maxSize = @$_GET["size"]; // we get the size o the file from url size @param
if(!isset($maxSize)){
	$maxSize = 100;
}

if(isset($path)){
	$thumb = new ThumbnailImage($path, $maxSize); // Create a new ThumbnailImage object instance
	$thumb->getImage(); // Call the getImage method in order to show the image file
}

?>