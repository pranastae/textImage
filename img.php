<?php
require_once "class.php";
$text = $_GET['text'];
$font = $_GET['font'] . ".ttf";

$stuff = new textImage();
$stuff->setProperties("#000", "#fff", array(700,24), 20);
$img = $stuff->convertToPNG ($text, $font);

if ($img != FALSE) {
	
	header('Content-Type: image/png');
	readfile ($img);
	
} else {
	echo "something wen't wrong.";
}

?>