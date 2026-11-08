<?php
require_once "config.php";

$query = "SELECT * FROM barang ORDER BY id ASC";
$result = $conn->query($query);
$messages = [
    'deleted' => 'Barang berhasil dihapus!',
    'used' => 'Barang tidak dapat dihapus karena masih digunakan dalam transaksi.',
    'not_found' => 'Barang tidak ditemukan.',
    'invalid' => 'ID barang tidak valid.',
    'failed' => 'Terjadi kesalahan saat menghapus barang.'
];
$status = $_GET['status'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            color: #2563eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 11px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #d9edf7;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
            border: none;
            padding: 7px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .back {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 13px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .message {
            padding: 12px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 5px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Data Master Barang</h2>
    <?php if (isset($messages[$status])): ?>
        <p class="message <?= $status === 'deleted' ? 'success' : '' ?>">
            <?= e($messages[$status]) ?>
        </p>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php $no = 1; ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= e($row['kode_barang']) ?></td>
                    <td><?= e($row['nama_barang']) ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td><?= e($row['stok']) ?></td>
                    <td>
                        <form method="POST"
                              action="hapus_barang.php"
                              onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                            <input type="hidden"
                                   name="id"
                                   value="<?= (int) $row['id'] ?>">
                            <button type="submit" class="btn-delete">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Belum ada data barang.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="index.php" class="back">Kembali ke Transaksi</a>
</div>
</body>
</html>
