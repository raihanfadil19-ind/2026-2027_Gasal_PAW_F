<?php
require_once "config.php";

// Pastikan penghapusan menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Mengambil ID supplier
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location: index.php?status=invalid");
    exit;
}

try {
    // Menghapus supplier berdasarkan ID
    $query = "DELETE FROM supplier WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: index.php?status=deleted");
    } else {
        header("Location: index.php?status=not_found");
    }

    $stmt->close();

} catch (mysqli_sql_exception $e) {

    // Supplier tidak bisa dihapus jika masih digunakan tabel lain
    if ($e->getCode() == 1451) {
        header("Location: index.php?status=related");
    } else {
        header("Location: index.php?status=failed");
    }
}

exit;
?>