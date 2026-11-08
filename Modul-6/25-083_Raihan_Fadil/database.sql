CREATE DATABASE IF NOT EXISTS db_penjualan_modul6;
USE db_penjualan_modul6;

CREATE TABLE supplier (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100),
    telp VARCHAR(12),
    alamat TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE barang (
    id INT NOT NULL AUTO_INCREMENT,
    kode_barang VARCHAR(10),
    nama_barang VARCHAR(100),
    harga INT,
    stok INT,
    supplier_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (supplier_id)
        REFERENCES supplier(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
    id VARCHAR(20) NOT NULL,
    nama VARCHAR(100),
    jenis_kelamin ENUM('L','P'),
    telp VARCHAR(12),
    alamat TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE transaksi (
    id INT NOT NULL AUTO_INCREMENT,
    waktu_transaksi DATE,
    keterangan TEXT,
    total INT,
    pelanggan_id VARCHAR(20),
    PRIMARY KEY (id),
    FOREIGN KEY (pelanggan_id)
        REFERENCES pelanggan(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    harga INT,
    qty INT,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id)
        REFERENCES transaksi(id)
        ON DELETE RESTRICT,
    FOREIGN KEY (barang_id)
        REFERENCES barang(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
    id INT NOT NULL AUTO_INCREMENT,
    waktu_bayar DATETIME,
    total INT,
    metode ENUM('TUNAI','TRANSFER','EDC'),
    transaksi_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (transaksi_id)
        REFERENCES transaksi(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE `user` (
    id_user TINYINT(2) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30),
    password VARCHAR(35),
    nama VARCHAR(50),
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT(1),
    PRIMARY KEY (id_user)
) ENGINE=InnoDB;