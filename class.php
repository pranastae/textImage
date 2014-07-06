<?php
class textImage {
	
	public $text = "";
	public $font = array("fonts/", "");
	public $fileName = array ("img/", "");
	public $textColor = array (0, 0, 0);
	public $backgroundColor = array (255, 255, 255);
	public $imgSize = array (600, 20);
	public $textSize = 12;
	
	public $err = FALSE;
	
	//setting all the parameters, if they are not set default values will be used
	public function setProperties ($inputColor, $inputBgColor, $inputImgSize, $inputTxtSize) {
		
		$this->textColor = ($inputColor != "" ? $inputColor = (!is_array($inputColor) ? $this->hex2rgb($inputColor) : $inputColor) : $this->textColor);
		$this->backgroundColor = ($inputBgColor != "" ? $inputColor = (!is_array($inputBgColor) ? $this->hex2rgb($inputBgColor) : $inputBgColor) : $this->backgroundColor);
		$this->imgSize = ($inputImgSize != "" ? $inputImgSize : $this->imgSize);
		$this->textSize = ($inputTxtSize != "" ? $inputTxtSize : $this->textSize);
		
	}
	
	//converting that text to image and stuff...
	public function convertTheStuff ($inputText, $inputFont) {
		
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
	
}
?>