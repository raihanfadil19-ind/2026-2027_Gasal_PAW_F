USE db_penjualan;

START TRANSACTION;
INSERT INTO supplier (id, nama, telp, alamat) VALUES
(1, 'PT Sumber Makmur', '081234567801', 'Surabaya'),
(2, 'CV Berkah Jaya', '081234567802', 'Bangkalan'),
(3, 'PT Mitra Sejahtera', '081234567803', 'Madura'),
(4, 'CV Digital Store', '081234567804', 'Gresik'),
(5, 'PT Teknologi Nusantara', '081234567805', 'Sidoarjo'),
(6, 'CV Cahaya Komputer', '081234567806', 'Lamongan'),
(7, 'PT Elektronik Mandiri', '081234567807', 'Mojokerto'),
(8, 'CV Sinar Abadi', '081234567808', 'Malang'),
(9, 'PT Global Hardware', '081234567809', 'Jombang'),
(10, 'CV Maju Bersama', '081234567810', 'Pasuruan');

INSERT INTO pelanggan
(id, nama, jenis_kelamin, telp, alamat) VALUES
(1, 'Ahmad Fauzi', 'L', '081111111101', 'Surabaya'),
(2, 'Siti Aminah', 'P', '081111111102', 'Bangkalan'),
(3, 'Budi Santoso', 'L', '081111111103', 'Sampang'),
(4, 'Dewi Lestari', 'P', '081111111104', 'Pamekasan'),
(5, 'Rizky Pratama', 'L', '081111111105', 'Sumenep'),
(6, 'Nur Aisyah', 'P', '081111111106', 'Gresik'),
(7, 'Andi Saputra', 'L', '081111111107', 'Sidoarjo'),
(8, 'Putri Amelia', 'P', '081111111108', 'Malang'),
(9, 'Fajar Ramadhan', 'L', '081111111109', 'Mojokerto'),
(10, 'Dina Safitri', 'P', '081111111110', 'Lamongan');

INSERT INTO barang
(id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1, 'BRG001', 'Mouse Wireless', 150000, 25, 1),
(2, 'BRG002', 'Keyboard Basic', 85000, 30, 2),
(3, 'BRG003', 'Monitor 24 Inch', 1750000, 10, 3),
(4, 'BRG004', 'USB Hub', 120000, 20, 4),
(5, 'BRG005', 'Flashdisk 64GB', 75000, 40, 5),
(6, 'BRG006', 'Headset Gaming', 250000, 15, 6),
(7, 'BRG007', 'Webcam HD', 300000, 12, 7),
(8, 'BRG008', 'Mousepad', 65000, 35, 8),
(9, 'BRG009', 'Kabel HDMI', 95000, 28, 9),
(10, 'BRG010', 'SSD 512GB', 650000, 8, 10);


-- 4. DATA TRANSAKSI (10 DATA)
INSERT INTO transaksi
(id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1, '2026-10-01 09:00:00', 'Pembelian mouse wireless', 300000, 1),
(2, '2026-10-02 10:15:00', 'Pembelian keyboard', 85000, 2),
(3, '2026-10-03 11:30:00', 'Pembelian monitor', 1750000, 3),
(4, '2026-10-04 13:00:00', 'Pembelian USB Hub', 360000, 4),
(5, '2026-10-05 14:20:00', 'Pembelian flashdisk', 150000, 5),
(6, '2026-10-06 09:45:00', 'Pembelian headset', 250000, 6),
(7, '2026-10-07 10:30:00', 'Pembelian webcam', 300000, 7),
(8, '2026-10-08 12:00:00', 'Pembelian mousepad', 130000, 8),
(9, '2026-10-09 15:10:00', 'Pembelian kabel HDMI', 95000, 9),
(10, '2026-10-10 16:00:00', 'Pembelian SSD', 650000, 10);


-- 5. DATA TRANSAKSI DETAIL (10 DATA)
INSERT INTO transaksi_detail
(transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 150000, 2),
(2, 2, 85000, 1),
(3, 3, 1750000, 1),
(4, 4, 120000, 3),
(5, 5, 75000, 2),
(6, 6, 250000, 1),
(7, 7, 300000, 1),
(8, 8, 65000, 2),
(9, 9, 95000, 1),
(10, 10, 650000, 1);


-- 6. DATA USER (10 DATA)
INSERT INTO `user`
(id_user, username, password, nama, alamat, hp, level) VALUES
(1, 'admin', 'admin123', 'Administrator', 'Surabaya', '082211111101', 1),
(2, 'user01', 'user123', 'Ahmad', 'Bangkalan', '082211111102', 2),
(3, 'user02', 'user123', 'Siti', 'Sampang', '082211111103', 2),
(4, 'user03', 'user123', 'Budi', 'Pamekasan', '082211111104', 2),
(5, 'user04', 'user123', 'Dewi', 'Sumenep', '082211111105', 2),
(6, 'user05', 'user123', 'Rizky', 'Gresik', '082211111106', 2),
(7, 'user06', 'user123', 'Nur', 'Sidoarjo', '082211111107', 2),
(8, 'user07', 'user123', 'Andi', 'Malang', '082211111108', 2),
(9, 'user08', 'user123', 'Putri', 'Mojokerto', '082211111109', 2),
(10, 'user09', 'user123', 'Fajar', 'Lamongan', '082211111110', 2);


-- 7. DATA PEMBAYARAN (10 DATA)
INSERT INTO pembayaran
(id, waktu_bayar, total, metode, transaksi_id) VALUES
(1, '2026-10-01 09:10:00', 300000, 'TUNAI', 1),
(2, '2026-10-02 10:20:00', 85000, 'TRANSFER', 2),
(3, '2026-10-03 11:40:00', 1750000, 'EDC', 3),
(4, '2026-10-04 13:10:00', 360000, 'TUNAI', 4),
(5, '2026-10-05 14:30:00', 150000, 'TRANSFER', 5),
(6, '2026-10-06 09:55:00', 250000, 'EDC', 6),
(7, '2026-10-07 10:40:00', 300000, 'TUNAI', 7),
(8, '2026-10-08 12:10:00', 130000, 'TRANSFER', 8),
(9, '2026-10-09 15:20:00', 95000, 'EDC', 9),
(10, '2026-10-10 16:10:00', 650000, 'TUNAI', 10);

COMMIT;