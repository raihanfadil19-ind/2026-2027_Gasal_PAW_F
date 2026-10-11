<?php
$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);

echo 'weight = ("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75")<br>';

$values = array_values($weight);

echo "Data kedua: " . $values[1];
?>