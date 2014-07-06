<?php
require_once "class.php";
$text = $_GET['text'];
$font = $_GET['font'] . ".ttf";

$stuff = new textImage();
$stuff->setProperties("#000", "#fff", array(500,80), 20);
$img = $stuff->convertTheStuff($text, $font);

if ($img != FALSE) {
	
	header('Content-Type: image/png');
	readfile ($img);
	
}

?>