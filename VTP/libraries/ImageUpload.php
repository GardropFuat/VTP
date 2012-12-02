<?php
/**
  * File Name: ImageUpload.php
  * Description: Class that handles image uploads.
  * Author: Anudeep Poltapally
  * Created: 12/01/12
  * Last Updated: 
  * Copyright: Echostar Systems @ http://www.echostar.com/
 */

class ImageUpload {
    private $imagePath = '';
	/**
     * Uploads Videos and Images
     * @param file $file - $_FILES information from the post.
     * @param string $directory - directory location
     * @param string $fileName - target file name
     * @param int $maxSize - Max file size(MB) allowed.
     * @param array $dimensions - restriction of height and width of the image 
     * @return true on success or custom error message on failure
     */
	public function File($file, $directory, $fileName, $maxSize, $dimensions= NULL) {
		$fileInfo = $this->FileInfo($file);
		$fileAllowed = $this->FileAllowed($fileInfo['fileType'], $fileInfo, $maxSize, $dimensions );
        $this->imagePath = $directory.$fileName.'.'.$fileInfo['fileExt'];        
		if($fileAllowed[0]) {
            if($fileInfo['fileType'] == 'image') {
				$upload = $this->Upload($fileInfo, $this->imagePath);
				return $upload;
			}
		}else {
			return $fileAllowed[1];
		}
	}
    
    public function GetImagePath() {
        return $this->imagePath;
    }
    
	/**
	 * Convenience function to group $_FILES info useful array
	 * @param file $file - $_FILES information from the post.
	 * @return array $fileInfo
	 */
	private function FileInfo($file) {
        $image = $file['image'];
		$fileInfo['fileError'] = $image['error'];
		$fileInfo['fileName'] = $image['name'];
		$fileInfo['fileTmpName'] = $image['tmp_name'];
			$type = explode("/",$image["type"]);
		$fileInfo['fileType'] = $type[0];
		$fileInfo['fileFormat'] = $type[1];
		$fileInfo['fileExt'] = strtolower ( substr($image["name"], strrpos($image["name"], '.') + 1) );
		$fileInfo['fileSize'] = $image['size'];
		return $fileInfo;
	}
	
    /**
	 * Checks to makes sure file meets requirements for upload
	 * @param string $fileType - Type of file beeing uploaded, (video, image)
	 * @param array $fileInfo - Array with information about the file being uploaded.
	 * @param int $maxSize - Max file size we are allowing for upload.
	 * @param string $dimensions - For images that have a restricted width and height
	 * @return array  $fileAllowed = true if file is ok to upload and $fileError=NULL, $fileAllowed = false  and $fileError = custom error message if it is not ok to upload
	 */
	private function FileAllowed($fileType, $fileInfo, $maxSize, $dimensions = NULL) {
		//At the point we are restricitng uploads to images and videos
			switch ($fileType) {
                case 'image':
					$allowedFormats = array("png","gif","jpg","jpeg","bmp","swf");
					break;
				default:
					return array(false, 'File format not allowed.');
					break;
			}
			$fileAllowed = true;
			$fileError = NULL;
			//Check File Format
				if(!in_array($fileInfo['fileExt'], $allowedFormats)) {
					$fileAllowed = false;
					$fileError = 'File format is not allowed. Allowed formats are: '.implode(', ', $allowedFormats).'.';
				}
			//Check File Size
				else if(($fileInfo['fileSize'] / 1048576) > $maxSize) {
					$fileAllowed = false;
					$fileError = 'File is larger then '.$maxSize.'MB';
				}
			//Check Dimensions on images
				else if(isset($dimensions)) {
					$dimensionsCheck = $this->DimensionsCheck($dimensions[0], $dimensions[1], $fileInfo['fileTmpName']);
					if($dimensionsCheck == false) {
						$fileAllowed = false;
						$fileError = 'File is not '.$dimensions[0].' by '.$dimensions[1].' px. Please upload a file with the appropriate dimensions.';
					}
				}
			return array($fileAllowed, $fileError);
	}
	
    /**
	 * Check the dimensions of an image file if it is restricted
	 * @param int $x - Width of image file.
	 * @param int $y - Height of image file.
	 * @param file $fileTmpName - tempory file name, $image['tmp_name'].
	 * @return true if matches, false if not
	 */
	private function DimensionsCheck($x, $y, $fileTmpName) {
		$size = getimagesize($fileTmpName);
        if($size[0] == $x && $size[1] == $y) {
            return true;
        }else {
            return false;
        }
	}

	/**
	 * Uploads Images to our server.  NOTE: STILL WORKING ON THIS Only setup for OpenX Right Now
	 * @param array $fileInfo - Array with information about the file being uploaded.
     * @param string $imagePath - path of image including filename.
	 * @return
	 */
	private function Upload($fileInfo, $imagePath) {        
        if(move_uploaded_file($fileInfo['fileTmpName'], $imagePath)) {
            return '';        
        }else {
            return 'Error';
        }
	}
}
?>