<?php

// 1. array_push()
$arr = array("A");

echo 'Array awal: ("A")<br>';

array_push($arr, "B");

echo "Hasil array_push: " . implode(" ", $arr) . "<br><br>";


// 2. array_merge()
$arr1 = array("A", "B");
$arr2 = array("C");

echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';

$hasilMerge = array_merge($arr1, $arr2);

echo "Hasil array_merge: " . implode(" ", $hasilMerge) . "<br><br>";


// 3. array_values()
$arr3 = array("X" => 1, "Y" => 2);

echo 'Array awal: ("X" => 1, "Y" => 2)<br>';

$hasilValues = array_values($arr3);

echo "Hasil array_values: " . implode(" ", $hasilValues) . "<br><br>";


// 4. array_search()
$arr4 = array("A", "B", "C");

echo 'Mencari "B" pada array: ("A", "B", "C")<br>';

$hasilSearch = array_search("B", $arr4);

echo "Hasil array_search: " . $hasilSearch . "<br><br>";


// 5. array_filter()
$arr5 = array(0, 1, false, 2, "", 3, "array");

echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';

$hasilFilter = array_filter($arr5);

echo "Hasil array_filter: " . implode(" ", $hasilFilter) . "<br><br>";


// 6. sort() dan rsort()
$arr6 = array(3, 1, 2);

echo "Array awal: (3, 1, 2)<br>";

$asc = $arr6;
sort($asc);
echo "Hasil sort: " . implode(" ", $asc) . "<br>";

$desc = $arr6;
rsort($desc);
echo "Hasil rsort: " . implode(" ", $desc) . "<br><br>";


// 7. Sorting array asosiatif
$ages = array(
    "Peter" => 35,
    "Ben" => 37,
    "Joe" => 43
);

function formatArray($array) {
    $hasil = [];

    foreach ($array as $key => $value) {
        $hasil[] = $key . "=>" . $value;
    }

    return implode(", ", $hasil);
}

echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$asort = $ages;
asort($asort);
echo "Hasil asort: " . formatArray($asort) . "<br>";

$ksort = $ages;
ksort($ksort);
echo "Hasil ksort: " . formatArray($ksort) . "<br>";

$arsort = $ages;
arsort($arsort);
echo "Hasil arsort: " . formatArray($arsort) . "<br>";

$krsort = $ages;
krsort($krsort);
echo "Hasil krsort: " . formatArray($krsort) . "<br>";

?>