<?php
include("connection.php");

// Fungsi untuk mengeksekusi perintah SQL
function executeSQL($sql, $connection) {
    if ($connection->query($sql) === TRUE) {
        echo "Tabel berhasil dibuat atau sudah ada.\n";
    } else {
        echo "Error creating table: " . $connection->error . "\n";
    }
}

// SQL untuk membuat tabel rating_mobil
$sqlRatingMobil = "
CREATE TABLE IF NOT EXISTS rating_mobil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mobil_id INT,
    user_id INT,
    rating INT,
    ulasan TEXT,
    tanggal_rating DATE,
    FOREIGN KEY (mobil_id) REFERENCES mobil(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
";

executeSQL($sqlRatingMobil, $connection);

// SQL untuk membuat tabel users
$sqlUsers = "
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
);
";

executeSQL($sqlUsers, $connection);

// SQL untuk membuat tabel pembelian
$sqlPembelian = "
CREATE TABLE pembelian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    mobil_id INT,
    tanggal_pembelian DATE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (mobil_id) REFERENCES mobil(id)
);
";

executeSQL($sqlPembelian, $connection);

// SQL untuk membuat tabel mobil
$sqlMobil = "
CREATE TABLE IF NOT EXISTS mobil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_mobil VARCHAR(255),
    merek VARCHAR(255),
    model VARCHAR(255),
    tahun INT,
    gambar VARCHAR(255),
    produsen_id INT,
    FOREIGN KEY (produsen_id) REFERENCES produsen(id)
);
";

executeSQL($sqlMobil, $connection);

// SQL untuk membuat tabel produsen
$sqlProdusen = "
CREATE TABLE IF NOT EXISTS produsen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produsen VARCHAR(255) NOT NULL,
    alamat_produsen TEXT,
    telepon_produsen VARCHAR(20)
);
";

executeSQL($sqlProdusen, $connection);

// Menutup koneksi setelah selesai
$connection->close();
?>
