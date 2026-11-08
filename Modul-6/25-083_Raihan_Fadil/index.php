
<?php
require_once "config.php";

$query = "
    SELECT
        t.id,
        t.waktu_transaksi,
        t.keterangan,
        t.total,
        p.nama AS nama_pelanggan
    FROM transaksi t
    LEFT JOIN pelanggan p
        ON t.pelanggan_id = p.id
    ORDER BY t.id ASC
";
$result = $conn->query($query);
$transaksiList = $result->fetch_all(MYSQLI_ASSOC);

$selectedTransaksi = null;
$selectionInvalid = false;

if (isset($_GET['transaksi_id'])) {
    $selectedId = filter_var(
        $_GET['transaksi_id'],
        FILTER_VALIDATE_INT
    );
    if ($selectedId === false || $selectedId <= 0) {
        $selectionInvalid = true;
    } else {
        foreach ($transaksiList as $transaksi) {
            if ((int) $transaksi['id'] === (int) $selectedId) {
                $selectedTransaksi = $transaksi;
                break;
            }
        }
        if (!$selectedTransaksi) {
            $selectionInvalid = true;
        }
    }
} elseif (!empty($transaksiList)) {
    $selectedTransaksi = $transaksiList[0];
}
$details = [];
if ($selectedTransaksi) {

    $queryDetail = "
        SELECT
            td.transaksi_id,
            td.barang_id,
            b.kode_barang,
            b.nama_barang,
            td.harga,
            td.qty,
            (td.harga * td.qty) AS subtotal
        FROM transaksi_detail td
        JOIN barang b
            ON td.barang_id = b.id
        WHERE td.transaksi_id = ?
        ORDER BY b.nama_barang ASC
    ";

    $stmt = $conn->prepare($queryDetail);
    $selectedId = (int) $selectedTransaksi['id'];
    $stmt->bind_param("i", $selectedId);
    $stmt->execute();

    $details = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Detail Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 25px;
        }
        .container {
            max-width: 1100px;
            margin: auto;
        }
        .card {
            background: white;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        h1 {
            color: #2563eb;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 11px;
            text-align: left;
        }
        th {
            background: #d9edf7;
        }
        tr:nth-child(even) {
            background: #f5f5f5;
        }
        .btn {
            display: inline-block;
            padding: 7px 12px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }
        .btn:hover {
            background: #1d4ed8;
        }
        .active {
            background: #dbeafe !important;
        }
        .info {
            padding: 12px;
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            margin-top: 15px;
        }
        .empty {
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Sistem Informasi Penjualan</h1>
    <a href="barang.php" class="btn">
        Kelola Data Barang
    </a>
    <!-- DATA MASTER -->
    <div class="card">
        <h2>Data Master Transaksi</h2>
        <a class="btn"
           href="tambah_detail.php?transaksi_id=<?= (int) $selectedTransaksi['id'] ?>">
            + Tambah Barang
        </a>
        <?php if (($_GET['status'] ?? '') === 'detail_added'): ?>
            <p style="background:#dcfce7; color:#166534; padding:10px;">
                Detail transaksi berhasil ditambahkan dan total diperbarui!
            </p>                
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Waktu Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Keterangan</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($transaksiList)): ?>
                <?php foreach ($transaksiList as $t): ?>
                    <tr class="<?= (
                        $selectedTransaksi &&
                        $selectedTransaksi['id'] == $t['id']
                    ) ? 'active' : '' ?>">
                        <td><?= e($t['id']) ?></td>
                        <td><?= e($t['waktu_transaksi']) ?></td>
                        <td><?= e($t['nama_pelanggan']) ?></td>
                        <td><?= e($t['keterangan']) ?></td>
                        <td>
                            Rp <?= number_format(
                                (float) $t['total'],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>
                        <td>
                            <a class="btn"
                               href="index.php?transaksi_id=<?= (int) $t['id'] ?>">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="empty">
                        Belum ada data transaksi.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- DATA DETAIL -->
    <div class="card" id="detail">
        <h2>Data Detail Transaksi</h2>
        <?php if ($selectionInvalid): ?>
            <p>Transaksi yang dipilih tidak ditemukan.</p>
        <?php elseif ($selectedTransaksi): ?>
            <div class="info">
                <strong>Transaksi ID:</strong>
                <?= e($selectedTransaksi['id']) ?>
                <br>
                <strong>Pelanggan:</strong>
                <?= e($selectedTransaksi['nama_pelanggan']) ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($details)): ?>
                    <?php foreach ($details as $d): ?>
                        <tr>
                            <td><?= e($d['kode_barang']) ?></td>
                            <td><?= e($d['nama_barang']) ?></td>
                            <td>
                                Rp <?= number_format(
                                    (float) $d['harga'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>
                            </td>
                            <td><?= e($d['qty']) ?></td>
                            <td>
                                Rp <?= number_format(
                                    (float) $d['subtotal'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty">
                            Belum ada detail transaksi.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Belum ada transaksi yang dapat ditampilkan.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
