USE db_penjualan_modul6;
START TRANSACTION;

INSERT INTO supplier (id, nama, telp, alamat) VALUES
(1, 'PT Sumber Makmur', '081234567801', 'Surabaya'),
(2, 'CV Berkah Jaya', '081234567802', 'Bangkalan'),
(3, 'PT Mitra Sejahtera', '081234567803', 'Sampang'),
(4, 'CV Digital Store', '081234567804', 'Gresik'),
(5, 'PT Teknologi Nusantara', '081234567805', 'Sidoarjo');

INSERT INTO barang
(id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1, 'BRG001', 'Mouse Wireless', 150000, 25, 1),
(2, 'BRG002', 'Keyboard Basic', 85000, 30, 2),
(3, 'BRG003', 'Monitor 24 Inch', 1750000, 10, 3),
(4, 'BRG004', 'Webcam HD', 300000, 15, 4),
(5, 'BRG005', 'SSD 512GB', 650000, 12, 5);

INSERT INTO pelanggan
(id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Ahmad Fauzi', 'L', '081111111101', 'Surabaya'),
('PLG002', 'Siti Aminah', 'P', '081111111102', 'Bangkalan'),
('PLG003', 'Budi Santoso', 'L', '081111111103', 'Sampang'),
('PLG004', 'Dewi Lestari', 'P', '081111111104', 'Pamekasan'),
('PLG005', 'Rizky Pratama', 'L', '081111111105', 'Sumenep');

INSERT INTO `user`
(id_user, username, password, nama, alamat, hp, level) VALUES
(1, 'admin', 'admin123', 'Administrator', 'Surabaya', '082211111101', 1),
(2, 'user01', 'user123', 'Ahmad', 'Bangkalan', '082211111102', 2),
(3, 'user02', 'user123', 'Siti', 'Sampang', '082211111103', 2),
(4, 'user03', 'user123', 'Budi', 'Pamekasan', '082211111104', 2),
(5, 'user04', 'user123', 'Dewi', 'Sumenep', '082211111105', 2);

INSERT INTO transaksi
(id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1, '2026-10-01', 'Pembelian mouse dan keyboard', 385000, 'PLG001'),
(2, '2026-10-02', 'Pembelian monitor dan webcam', 2050000, 'PLG002'),
(3, '2026-10-03', 'Pembelian SSD dan mouse', 800000, 'PLG003'),
(4, '2026-10-04', 'Pembelian keyboard dan monitor', 1920000, 'PLG004'),
(5, '2026-10-05', 'Pembelian webcam dan SSD', 1250000, 'PLG005'),
(6, '2026-10-06', 'Pembelian tiga mouse', 450000, 'PLG001'),
(7, '2026-10-07', 'Pembelian keyboard', 85000, 'PLG002'),
(8, '2026-10-08', 'Pembelian monitor', 1750000, 'PLG003'),
(9, '2026-10-09', 'Pembelian webcam', 300000, 'PLG004'),
(10, '2026-10-10', 'Pembelian dua SSD', 1300000, 'PLG005');

INSERT INTO transaksi_detail
(transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 150000, 2),
(1, 2, 85000, 1),

(2, 3, 1750000, 1),
(2, 4, 300000, 1),

(3, 5, 650000, 1),
(3, 1, 150000, 1),

(4, 2, 85000, 2),
(4, 3, 1750000, 1),

(5, 4, 300000, 2),
(5, 5, 650000, 1),

(6, 1, 150000, 3),
(7, 2, 85000, 1),
(8, 3, 1750000, 1),
(9, 4, 300000, 1),
(10, 5, 650000, 2);

INSERT INTO pembayaran
(id, waktu_bayar, total, metode, transaksi_id) VALUES
(1, '2026-10-01 09:10:00', 385000, 'TUNAI', 1),
(2, '2026-10-02 10:20:00', 2050000, 'TRANSFER', 2),
(3, '2026-10-03 11:30:00', 800000, 'EDC', 3),
(4, '2026-10-04 13:10:00', 1920000, 'TUNAI', 4),
(5, '2026-10-05 14:20:00', 1250000, 'TRANSFER', 5),
(6, '2026-10-06 09:45:00', 450000, 'EDC', 6),
(7, '2026-10-07 10:30:00', 85000, 'TUNAI', 7),
(8, '2026-10-08 12:00:00', 1750000, 'TRANSFER', 8),
(9, '2026-10-09 15:10:00', 300000, 'EDC', 9),
(10, '2026-10-10 16:00:00', 1300000, 'TUNAI', 10);

COMMIT;
