<?php
require_once "config.php";

// Mengambil ID supplier dari URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("ID supplier tidak valid.");
}

// Mengambil data supplier berdasarkan ID
$stmt = $conn->prepare(
    "SELECT nama, telp, alamat FROM supplier WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nama, $telp, $alamat);

if (!$stmt->fetch()) {
    die("Data supplier tidak ditemukan.");
}

$stmt->close();

$errors = [];

// Memproses perubahan data
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama = trim($_POST["nama"] ?? "");
    $telp = trim($_POST["telp"] ?? "");
    $alamat = trim($_POST["alamat"] ?? "");

    // Validasi nama
    if ($nama === "") {
        $errors[] = "Nama supplier wajib diisi.";
    }

    // Validasi nomor telepon
    if ($telp !== "" && !preg_match("/^[0-9]{1,12}$/", $telp)) {
        $errors[] = "Nomor telepon harus berupa angka, maksimal 12 digit.";
    }

    // Jika tidak ada kesalahan, update database
    if (empty($errors)) {

        $query = "UPDATE supplier
                  SET nama = ?, telp = ?, alamat = ?
                  WHERE id = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $nama, $telp, $alamat, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php?status=updated");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        button, .back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }
        button {
            background: #2563eb;
            color: white;
        }
        .back {
            background: #ddd;
            color: #333;
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Edit Supplier</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?= e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">

        <label>Nama Supplier</label>
        <input
            type="text"
            name="nama"
            value="<?= e($nama); ?>"
            maxlength="100"
            required
        >

        <label>Nomor Telepon</label>
        <input
            type="text"
            name="telp"
            value="<?= e($telp); ?>"
            maxlength="12"
            inputmode="numeric"
        >

        <label>Alamat</label>
        <textarea name="alamat"><?= e($alamat); ?></textarea>

        <button type="submit">Simpan Perubahan</button>

        <a href="index.php" class="back">Kembali</a>

    </form>

</div>

</body>
</html>