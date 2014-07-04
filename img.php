<?php
require_once "class.php";
$text = $_GET['text'];
$font = "fonts/".$_GET['font'].".ttf";
$file = "img/".$_GET['file'].".png";

$stuff = new textImage();
$stuff->setProperties(array(0,0,0), array(254,254,254), array(500,80), 20);

if (file_exists($file)){
	readfile($file);
} else {
	$stuff->convertTheStuff($text, $font, $file);
	readfile($file);
}
?>