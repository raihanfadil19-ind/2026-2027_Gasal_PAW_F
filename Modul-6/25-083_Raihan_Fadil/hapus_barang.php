<?php
require_once "config.php";
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: barang.php");
    exit;
}
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id <= 0) {
    header("Location: barang.php?status=invalid");
    exit;
}
$stmt = $conn->prepare(
    "SELECT id FROM barang WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$barang = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$barang) {
    header("Location: barang.php?status=not_found");
    exit;
}
$stmt = $conn->prepare(
    "SELECT COUNT(*) AS jumlah
     FROM transaksi_detail
     WHERE barang_id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$cek = $stmt->get_result()->fetch_assoc();
$stmt->close();
if ($cek['jumlah'] > 0) {
    header("Location: barang.php?status=used");
    exit;
}

try {
    $stmt = $conn->prepare(
        "DELETE FROM barang WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        header("Location: barang.php?status=deleted");
    } else {
        header("Location: barang.php?status=not_found");
    }
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    header("Location: barang.php?status=failed");
}
exit;
?>
