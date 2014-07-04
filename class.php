<?php
class textImage {
	
	public $text = "";
	public $font = "";
	public $fileName = "";
	public $textColor = array (0, 0, 0);
	public $backgroundColor = array (255, 255, 255);
	public $imgSize = array (600, 20);
	public $textSize = 12;
	
	public $err = FALSE;

	public function setProperties ($inputColor, $inputBgColor, $inputImgSize, $inputTxtSize) {
		
		//properties of the image and text
		$this->textColor = ($inputColor != "" ? $inputColor : $this->textColor);
		$this->backgroundColor = ($inputBgColor != "" ? $inputBgColor : $this->backgroundColor);
		$this->imgSize = ($inputImgSize != "" ? $inputImgSize : $this->imgSize);
		$this->textSize = ($inputTxtSize != "" ? $inputTxtSize : $this->textSize);
		
	}
	
	public function convertTheStuff ($inputText, $inputFont, $inputFileName) {
		
		$this->text = ($inputText != "" ? $inputText : $this->err = TRUE);
		$this->font = ($inputFont != "" ? $inputFont : $this->err = TRUE);
		$this->fileName = ($inputFileName != "" ? $inputFileName : $this->err = TRUE);
		
		if ($this->err == FALSE){
			header('Content-Type: image/png');
			$image = imagecreatetruecolor($this->imgSize[0], $this->imgSize[1]);
			$backgroundColorCreate = imagecolorallocate($image, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
			$textColorCreate = imagecolorallocate($image, $this->textColor[0], $this->textColor[1], $this->textColor[2]);
			imagefilledrectangle($image, 0, 0, $this->imgSize[0], $this->imgSize[1], $backgroundColorCreate);
			imagettftext($image, $this->textSize, 0, 10, $this->textSize+1, $textColorCreate, $this->font, $this->text);
			imagepng($image, $this->fileName, 1, PNG_NO_FILTER);
			imagedestroy($image);
		} else {
			return NULL;
		}
		
	}
	
}
?>