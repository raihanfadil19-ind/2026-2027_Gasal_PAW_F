<?php
$height = array(
    "Andy" => "176",
    "Barry" => "165",
    "Charlie" => "170"
);

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

$items = [];
foreach ($height as $name => $value) {
    $items[] = '"' . $name . '"=>"' . $value . '"';
}

echo "height = (" . implode(", ", $items) . ")<br>";
echo "Nilai dengan indeks terakhir: " . end($height) . "<br><br>";

unset($height["Barry"]);

$items = [];
foreach ($height as $name => $value) {
    $items[] = '"' . $name . '"=>"' . $value . '"';
}

echo "height = (" . implode(", ", $items) . ")<br>";
echo "Nilai dengan indeks terakhir setelah dihapus: " . end($height);
?>