<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo 'fruits = ("' . implode('","', $fruits) . '")<br>';

$indeksTertinggi = max(array_keys($fruits));
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeksTertinggi];
?>