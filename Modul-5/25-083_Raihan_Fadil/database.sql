CREATE DATABASE IF NOT EXISTS db_penjualan;
USE db_penjualan;

-- 1. Tabel supplier
CREATE TABLE supplier (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12),
    alamat TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

-- 2. Tabel pelanggan
CREATE TABLE pelanggan (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    telp VARCHAR(12),
    alamat TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

-- 3. Tabel barang
CREATE TABLE barang (
    id INT(11) NOT NULL AUTO_INCREMENT,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT(11) NOT NULL,
    stok INT(11) NOT NULL,
    supplier_id INT(11) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_barang_supplier
        FOREIGN KEY (supplier_id) REFERENCES supplier(id)
) ENGINE=InnoDB;

-- 4. Tabel transaksi
CREATE TABLE transaksi (
    id INT(11) NOT NULL AUTO_INCREMENT,
    waktu_transaksi DATETIME NOT NULL,
    keterangan TEXT,
    total INT(11) NOT NULL,
    pelanggan_id INT(11) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_transaksi_pelanggan
        FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
) ENGINE=InnoDB;

-- 5. Tabel transaksi_detail
CREATE TABLE transaksi_detail (
    transaksi_id INT(11) NOT NULL,
    barang_id INT(11) NOT NULL,
    harga INT(11) NOT NULL,
    qty INT(11) NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    CONSTRAINT fk_detail_transaksi
        FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
    CONSTRAINT fk_detail_barang
        FOREIGN KEY (barang_id) REFERENCES barang(id)
) ENGINE=InnoDB;

-- 6. Tabel user
CREATE TABLE `user` (
    id_user TINYINT(2) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(35) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(50),
    hp VARCHAR(20),
    level TINYINT(1) NOT NULL,
    PRIMARY KEY (id_user)
) ENGINE=InnoDB;

-- 7. Tabel pembayaran
CREATE TABLE pembayaran (
    id INT(11) NOT NULL AUTO_INCREMENT,
    waktu_bayar DATETIME NOT NULL,
    total INT(11) NOT NULL,
    metode ENUM('TUNAI', 'TRANSFER', 'EDC') NOT NULL,
    transaksi_id INT(11) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_pembayaran_transaksi
        FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
) ENGINE=InnoDB;