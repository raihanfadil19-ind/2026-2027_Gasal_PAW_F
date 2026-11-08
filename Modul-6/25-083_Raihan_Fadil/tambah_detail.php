<?php
require_once "config.php";
$errors = [];

$transaksiId = $_GET['transaksi_id'] ?? $_POST['transaksi_id'] ?? '';
$transaksiId = filter_var(
    $transaksiId,
    FILTER_VALIDATE_INT
);
if (!$transaksiId || $transaksiId <= 0) {
    http_response_code(400);
    die("ID transaksi tidak valid.");
}

$stmt = $conn->prepare(
    "SELECT id, total FROM transaksi WHERE id = ?"
);
$stmt->bind_param("i", $transaksiId);
$stmt->execute();
$transaksi = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$transaksi) {
    http_response_code(404);
    die("Transaksi tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barangId = filter_var(
        $_POST['barang_id'] ?? '',
        FILTER_VALIDATE_INT
    );
    $qty = filter_var(
        $_POST['qty'] ?? '',
        FILTER_VALIDATE_INT
    );

    if (!$barangId || $barangId <= 0) {
        $errors[] = "Barang harus dipilih.";
    }
    if ($qty === false || $qty <= 0) {
        $errors[] = "Jumlah barang harus berupa bilangan bulat lebih dari 0.";
    }
    if (empty($errors)) {
        try {
            $conn->begin_transaction();

            $stmt = $conn->prepare(
                "SELECT harga FROM barang WHERE id = ?"
            );
            $stmt->bind_param("i", $barangId);
            $stmt->execute();
            $barang = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$barang) {
                throw new Exception("Barang tidak ditemukan.");
            }
            $harga = (int) $barang['harga'];

            $stmt = $conn->prepare(
                "SELECT COUNT(*) AS jumlah
                 FROM transaksi_detail
                 WHERE transaksi_id = ? AND barang_id = ?"
            );
            $stmt->bind_param("ii", $transaksiId, $barangId);
            $stmt->execute();
            $cek = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($cek['jumlah'] > 0) {
                throw new Exception(
                    "Barang tersebut sudah ada dalam transaksi."
                );
            }

            $stmt = $conn->prepare(
                "INSERT INTO transaksi_detail
                 (transaksi_id, barang_id, harga, qty)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param(
                "iiii",
                $transaksiId,
                $barangId,
                $harga,
                $qty
            );
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare(
                "SELECT COALESCE(SUM(harga * qty), 0) AS total
                 FROM transaksi_detail
                 WHERE transaksi_id = ?"
            );

            $stmt->bind_param("i", $transaksiId);
            $stmt->execute();

            $hasil = $stmt->get_result()->fetch_assoc();
            $totalBaru = (int) $hasil['total'];
            $stmt->close();

            $stmt = $conn->prepare(
                "UPDATE transaksi
                 SET total = ?
                 WHERE id = ?"
            );
            $stmt->bind_param(
                "ii",
                $totalBaru,
                $transaksiId
            );
            $stmt->execute();
            $stmt->close();
            $conn->commit();
            header(
                "Location: index.php?transaksi_id=" .
                $transaksiId . "&status=detail_added"
            );
            exit;
        } catch (Throwable $e) {
            $conn->rollback();
            $errors[] = $e instanceof Exception
                ? $e->getMessage()
                : "Gagal menyimpan detail transaksi.";
        }
    }
}

$stmt = $conn->prepare(
    "SELECT b.id, b.kode_barang, b.nama_barang, b.harga
     FROM barang b
     WHERE NOT EXISTS (
         SELECT 1
         FROM transaksi_detail td
         WHERE td.transaksi_id = ?
         AND td.barang_id = b.id
     )
     ORDER BY b.nama_barang ASC"
);
$stmt->bind_param("i", $transaksiId);
$stmt->execute();
$barangList = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Detail Transaksi</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            color: #2563eb;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button, .back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background: #75b843;
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

        .info {
            background: #eff6ff;
            padding: 12px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Tambah Detail Transaksi</h2>
    <div class="info">
        <strong>ID Transaksi:</strong>
        <?= e($transaksi['id']) ?>
        <br>
        <strong>Total Saat Ini:</strong>
        Rp <?= number_format($transaksi['total'], 0, ',', '.') ?>
    </div>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?= e($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($barangList)): ?>
        <form method="POST" action="">
            <input type="hidden"
                   name="transaksi_id"
                   value="<?= e($transaksiId) ?>">
            <label>Nama Barang</label>
            <select name="barang_id" required>
                <option value="">-- Pilih Barang --</option>
                <?php foreach ($barangList as $barang): ?>
                    <option value="<?= e($barang['id']) ?>">
                        <?= e($barang['kode_barang']) ?>     -
                        <?= e($barang['nama_barang']) ?>
                        (Rp <?= number_format($barang['harga'], 0, ',', '.') ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <label>Jumlah Barang (Qty)</label>
            <input
                type="number"
                name="qty"
                min="1"
                step="1"
                required
            >
            <button type="submit">
                Simpan Detail
            </button>
            <a href="index.php?transaksi_id=<?= e($transaksiId) ?>"
               class="back">
                Kembali
            </a>
        </form>
    <?php else: ?>
        <p>Semua barang sudah dimasukkan ke transaksi ini.</p>
        <a href="index.php?transaksi_id=<?= e($transaksiId) ?>"
           class="back">
            Kembali
        </a>
    <?php endif; ?>
</div>
</body>
</html>
