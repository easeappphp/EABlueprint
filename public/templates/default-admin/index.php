<b> hello everyone, my name is <?php echo $name; ?></b>

<?php
for ($x = 0; $x <= 10; $x++) {
  echo "The number is: " . $x . "\n";
} 

echo "\n";
foreach ($colors as $value) {
  echo "$value \n";
}
?>