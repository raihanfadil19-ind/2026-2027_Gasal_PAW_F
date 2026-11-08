<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$username = "root";
$password = "";
$database = "db_penjualan_modul6";

try {
    $conn = new mysqli(
        $host,
        $username,
        $password,
        $database
    );

    $conn->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Fungsi untuk mengamankan output HTML
function e($data)
{
    return htmlspecialchars(
        (string) $data,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>