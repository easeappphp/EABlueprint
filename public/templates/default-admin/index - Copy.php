<?php 
$echoVarible = "";
$echoVarible = $echoVarible . "<b> hello everyone, my name is " . $name . "</b>";

for ($x = 0; $x <= 10; $x++) {
  $echoVarible = $echoVarible . "The number is: " . $x . "\n";
} 

$echoVarible = $echoVarible . "\n";
foreach ($colors as $value) {
  $echoVarible = $echoVarible . "$value \n";
} ?>