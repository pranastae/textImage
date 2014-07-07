<?php
/**
 *     Simple class to convert any text into png image, point is to use ANY ttf font you want and not be limited by users font library.
 *     How to use it ?
 *     simple, just call the class:
 *     
 * $myClass = new textImage();
 *     
 *     once you call it, either set values at the point you call it with:
 * 
 * $myClass->setproperties((rgb color code as 3 value array or string as hex color code), (rgb color code as 3 value array or string as hex color code), (int image width, int image height), int text size);
 * 
 *     after setting values call:
 *  
 * $imageURI = $myClass->convertToPNG ("text string", "font name string");
 * 
 *     it will save the .png file with unique name to those specific properties and data and it will return img URI or if it exists it will just return the URI
 *     OR if something went wrong it will just return FALSE.
 *     so $imageURI will either be image URI or it will be FALSE.
 *     
 *     Questions, thoughts or anything else: tibor@hudik.de
 */
class textImage {
	
	public $text = "";
	public $font = array("fonts/", "");
	public $fileName = array ("img/", "");
	public $textColor = array (0, 0, 0);
	public $backgroundColor = array (255, 255, 255);
	public $imgSize = array (600, 20);
	public $textSize = 12;
	
	public $err = FALSE;

	//converting hex color code to rgb color code -> eg. #000000 will be array(0, 0, 0)
	private function hex2rgb($hex) {
	
		$hex = str_replace("#", "", $hex);
	
		if(strlen($hex) == 3) {
	
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	
		} else if (strlen($hex) == 6) {
	
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
	
		} else {
	
			return NULL;
	
		}
	
		$rgb = array($r, $g, $b);
	
		return $rgb;
	
	}
	
	//setting all the parameters, if they are not set default values will be used
	public function setProperties ($inputColor, $inputBgColor, $inputImgSize, $inputTxtSize) {
		
		$this->textColor = ($inputColor != "" ? $inputColor = (!is_array($inputColor) ? $this->hex2rgb($inputColor) : $inputColor) : $this->textColor);
		$this->backgroundColor = ($inputBgColor != "" ? $inputColor = (!is_array($inputBgColor) ? $this->hex2rgb($inputBgColor) : $inputBgColor) : $this->backgroundColor);
		$this->imgSize = ($inputImgSize != "" ? $inputImgSize : $this->imgSize);
		$this->textSize = ($inputTxtSize != "" ? $inputTxtSize : $this->textSize);
		
	}
	
	//converting that text to image and stuff...
	public function convertToPNG ($inputText, $inputFont) {
		
		$this->text = ($inputText != "" ? $inputText : $this->err = TRUE);
		$this->font[1] = ($inputFont != "" && file_exists($this->font[0].$this->font[1]) ? $inputFont : $this->err = TRUE);
		
		if ($this->err == FALSE){
			
				
			$this->fileName[1] = md5($inputText . $inputFont . $this->textColor[0] . $this->textColor[1] . $this->textColor[2] . 
					$this->backgroundColor[0] . $this->backgroundColor[1] . $this->backgroundColor[2] . $this->imgSize[0] . $this->imgSize[1] . $this->textSize);
			
			if (file_exists($this->fileName[0].$this->fileName[1].".png")){
				
				return $this->fileName[0].$this->fileName[1].".png";
				
			} else {
				
				header('Content-Type: image/png');
				$image = imagecreatetruecolor($this->imgSize[0], $this->imgSize[1]);
				$backgroundColorCreate = imagecolorallocate($image, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
				$textColorCreate = imagecolorallocate($image, $this->textColor[0], $this->textColor[1], $this->textColor[2]);
				imagefilledrectangle($image, 0, 0, $this->imgSize[0], $this->imgSize[1], $backgroundColorCreate);
				imagettftext($image, $this->textSize, 0, 10, $this->textSize+1, $textColorCreate, $this->font[0].$this->font[1], $this->text);
				imagepng($image, $this->fileName[0].$this->fileName[1].".png", 1, PNG_NO_FILTER);
				imagedestroy($image);
				
				return $this->fileName[0].$this->fileName[1].".png";
			}
		
		} else {
			
			return FALSE;
			
		}
		
	}
	
}
?>