<?php
$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);

echo 'weight = ("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75")<br><br>';

$names = array_keys($weight);
$arrlength = count($weight);

for ($i = 0; $i < $arrlength; $i++) {
    echo $names[$i] . " is " . $weight[$names[$i]] . " kg.<br>";
}
?>