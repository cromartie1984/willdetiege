<?php

// Set the content-type
header('Content-type: image/png');

// The text to draw
$text = $_GET["text"];
$type_contact = $_GET["type_contact"];
$type_bg = $_GET["color_bg"];

// Create a 100*30 image
if ($type_contact === "email") {
    $im = imagecreate(250, 30);
} else {
    $im = imagecreate(150, 30);
}
// White background and blue text

if ($type_bg === "white") {
    $bg_white = imagecolorallocate($im, 255, 255, 255);
    imagecolortransparent($im, $bg_white);
    $textcolor = imagecolorallocate($im, 161, 177, 188);
} else {
    $bg_black = imagecolorallocate($im, 0, 0, 0);
    imagecolortransparent($im, $bg_black);
    $textcolor = imagecolorallocate($im, 255, 255, 255);
}
$grey = imagecolorallocate($im, 128, 128, 128);

$font = '../font/roboto/Roboto-Regular.ttf';


// Add some shadow to the text
//imagettftext($im, 12, 0, 1, 15, $grey, $font, $text);
// Add the text
imagettftext($im, 12, 0, 0, 14, $textcolor, $font,$text);


imagepng($im);
imagedestroy($im);

$font = '/css/font/Roboto-Regular.ttf';
