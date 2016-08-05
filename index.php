<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Directory Navigation</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="author" content="Peter Lavin" />
<meta http-equiv="Content-Language" content="EN" />
<meta name="copyright" content="copyright softcoded.com" />
<meta name="robots" content="follow, index" />
<meta name="abstract" content="" />
</head>
<body>
<?php
require 'DirectoryItems.php';
//
$directory = 'graphics';
$di = new DirectoryItems($directory); // Create a new DirectoryItems object instance
$di->imagesOnly(); // Call the imagesOnly method
$di->naturalCaseInsensitiveOrder(); // Call the naturalCaseInsensitiveOrder merthod in order to sort the files
echo "<div style=\"text-align:center;\">";
echo "Click the file name to view full-sized version.<br />";
$filearray = $di->getFileArray(); // We store all the files of the directory in an array variable
$path = "";
$size = 100;

// We loop in each file and get the name and the extension to use them as a source on the image tag
foreach ($filearray as $key => $value){
  $path = "$directory/".$key; 
  /*errors in getthumb or in class will result in broken links
  - error will not display*/
  // The image tag calls the hetthumb.php script file
  echo "<img src=\"getthumb.php?path=$path&amp;size=$size\" ".
    "style=\"border:1px solid black;margin-top:20px;\" ".
    "alt= \"$value\" /><br />\n";
  echo "<a href=\"$path\" target=\"_blank\" >";
  echo "Title: $value</a> <br />\n";
}
echo "</div><br />";
?>
</body>
</html>