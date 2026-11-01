<?php
require_once "config.php";

// Mengambil seluruh data supplier
$query = "SELECT * FROM supplier ORDER BY id ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Supplier</title>
    <?php
    $status = $_GET['status'] ?? '';
    $messages = [
        'deleted' => 'Supplier berhasil dihapus!',
        'invalid' => 'ID supplier tidak valid.',
        'not_found' => 'Data supplier tidak ditemukan.',
        'related' => 'Supplier tidak dapat dihapus karena masih digunakan oleh data barang.',
        'failed' => 'Terjadi kesalahan saat menghapus supplier.'
    ];
    if (isset($messages[$status])):
    ?>
        <p style="padding:10px; background:#dcfce7; color:#166534;">
            <?= e($messages[$status]); ?>
        </p>
    <?php endif; ?>
    <style>
        /* Tombol tambah */
        .btn-add {
            display: inline-block;
            background: #75b843;
            color: white;
            padding: 8px 13px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            border: none;
        }
        /* Tombol edit */
        .btn-edit {
            display: inline-block;
            background: #e87818;
            color: white;
            padding: 7px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            border: none;
        }
        /* Tombol hapus */
        .btn-delete {
            background: #d92222;
            color: white;
            padding: 7px 12px;
            border-radius: 4px;
            font-size: 13px;
            border: none;
            cursor: pointer;
        }
        .btn-add:hover {
            background: #619d35;
        }
        .btn-edit:hover {
            background: #ca6410;
        }
        .btn-delete:hover {
            background: #b91c1c;
        }
        /* Posisi tombol */
        .actions {
            display: flex;
            gap: 5px;
            align-items: center;
        }
        .actions form {
            margin: 0;
        }
        /* Header tabel */
        th {
            background: #d9edf7;
            color: #333;
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #81cffc;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .jumlah {
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Data Supplier</h2>
    <a href="create.php" class="btn-add">
        Tambah Data
    </a>
    <?php if (isset($_GET['status']) && $_GET['status'] === 'created'): ?>
        <p style="padding:10px; background:#dcfce7; color:#166534;">
            Supplier berhasil ditambahkan!
        </p>
    <?php endif; ?>
    <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
        <p style="padding:10px; background:#dbeafe; color:#1e40af;">
            Data supplier berhasil diperbarui!
        </p>
    <?php endif; ?>
    <p class="jumlah">
        Daftar seluruh supplier yang tersimpan dalam database.
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= e($row['nama']); ?></td>
                    <td><?= e($row['telp']); ?></td>
                    <td><?= e($row['alamat']); ?></td>      
                    <td>
                        <div class="actions">        
                            <a class="btn-edit"
                               href="edit.php?id=<?= (int) $row['id']; ?>">
                                Edit
                            </a>
                            <form action="delete.php" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus supplier ini?');">
                                <input type="hidden" name="id"
                                       value="<?= (int) $row['id']; ?>">
                                <button type="submit" class="btn-delete">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php
                endwhile;
            else:
            ?>
                <tr>
                    <td colspan="4">Belum ada data supplier.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <p class="jumlah">
        Total supplier:
        <strong><?= $result->num_rows; ?></strong> data
    </p>
</div>
</body>
</html>