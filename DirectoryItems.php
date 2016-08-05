<?php

class DirectoryItems{
    private $fileArray = array();

    public function __construct($directory, $replacechar = "_"){
		$this->directory = $directory;
		$this->replacechar = $replacechar;
        $d = "";
        if(is_dir($directory)){
            $d = opendir($directory) or die("Failed to open directory.'");
            while(false !== ($f = readdir($d))){
                if(is_file("$directory/$f")){
					$title = $this->createTitle($f);
                    $this->fileArray[$f] = $title;

                } // end if

            } // end while
            closedir($d);
        }else{
            // error
            die("You must pass a directory name!");
        } // end if
    } // end method
	
	// With this method we create the title of the image
	private function createTitle($title){
		//strip extension
		$title = substr($title, 0, strpos($title, "."));
		//replace word seperator
		$title = str_replace($this->replacechar, " ", $title);
		return $title;
	}
	
	public function getFileArray(){
		return $this->fileArray;
	}


    function indexOrder(){
        sort($this->fileArray);
    }

    ///////////////////////////////////////////////////////////////////
	// We sort the array of file with the natcasesort sorting algorithm
    function naturalCaseInsensitiveOrder(){
        natcasesort($this->fileArray);
    }

    ///////////////////////////////////////////////////////////////////
    function getCount(){
        return count($this->fileArray);
    }
	
	// We check if the files in the directory are all image files
    public function checkAllImages(){
        $bln = true;
        $extension = "";
        $types = array("jpg", "jpeg", "gif", "png");
        foreach($this->fileArray as $key => $value){
            $extension = substr($value, (strpos($value, ".") + 1));
            $extension = strtolower($extension);
            if(!in_array($extension, $types)){
                $bln = false;
                break;
            }
        }
        return $bln;
    }
	
	// We can use this method to check for a specific file extension in the directory
	public function checkAllSpecificType($extension){
		$extension = strtolower($extension);
		$bln = true;
		$ext = "";
		foreach($this->fileArray as $key => $value){
			$ext = substr($key, (strpos($key, ".") + 1));
			$ext = strtolower($ext);
			if($extension != $ext){
				$bln = false;
				break;
			}
		}
		return $bln;
	}
	
	// We can use this method in to filter our files from the directory
	public function filter($extension){
		$extension = strtolower($extension);
		foreach($this->fileArray as $key => $value){
			$ext = substr($key,(strpos($key, ".") + 1));
			$ext = strtolower($ext);
			if($ext != $extension){
				unset($this->fileArray[$key]);
			}
		}
	}
	
	// We check the directory for specific image files extensions
	public function imagesOnly(){
		$extension = "";
		$types = array("jpg", "jpeg", "gif", "png");
		foreach($this->fileArray as $key => $value){
			$extension = substr($key, (strpos($key, ".") + 1));
			$extension = strtolower($extension);
			if(!in_array($extension, $types)){
				unset($this->fileArray);
			}
		}
	}

} // end of DirectoryItems class

?>
