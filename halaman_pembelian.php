<?php
session_start();
include("connection.php");
include("conn.php");

// Periksa apakah mobil_id dikirim dari form
if (!isset($_POST['mobil_id'])) {
    echo "<p>Mobil tidak ditemukan!</p>";
    exit();
}

$mobil_id = intval($_POST['mobil_id']);

// Ambil data mobil dari database
$query = "SELECT * FROM mobil WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$mobil_id]);

if ($stmt->rowCount() === 0) {
    echo "<p>Mobil tidak ditemukan!</p>";
    exit();
}

$mobil = $stmt->fetch(PDO::FETCH_ASSOC);

// Nomor WhatsApp penjual
$wa_number = "628123456789"; // Ganti dengan nomor WhatsApp penjual
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Pelanggan';

// Pesan otomatis WhatsApp
$wa_message = urlencode("Halo, saya $username tertarik membeli mobil " . $mobil['nama_mobil'] . ". Mohon informasi lebih lanjut.");
$wa_url = "https://wa.me/$wa_number?text=$wa_message";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pembelian</title>
    <link rel="stylesheet" href="css/style_sakkarepmu.css">
</head>
<body>
    <div class="container">
        <h1>Halaman Pembelian</h1>
        <p>Silakan hubungi penjual melalui WhatsApp untuk melanjutkan proses pembelian.</p>

        <!-- Informasi Mobil -->
        <p><strong>Nama Mobil:</strong> <?= htmlspecialchars($mobil['nama_mobil']); ?></p>
        <p><strong>Merek:</strong> <?= htmlspecialchars($mobil['merek']); ?></p>

        <!-- Tombol WhatsApp -->
        <a href="<?= $wa_url; ?>" target="_blank" class="btn-whatsapp">Chat Penjual via WhatsApp</a>

        <!-- Lokasi Toko -->
        <h2>Lokasi Toko</h2>
        <p>Alamat: Jl. Ketintang Brt. No.78, Ketintang, Kec. Gayungan, Surabaya, Jawa Timur 60231</p>
        <div class="map-container">
            <!-- Google Maps Embed dengan Pin Lokasi Baru -->
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.269544611782!2d112.7216011742955!3d-7.307562694464252!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fbf3e1e56c19%3A0x0!2zLTcKwzE4JzI3LjIiUyAxMTLCsDQzJzIwLjAiRQ!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                width="100%" 
                height="300" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <br>
        <a href="index.php">Kembali ke Beranda</a>
    </div>

    <style>
        .btn-whatsapp {
            display: inline-block;
            padding: 10px 20px;
            background-color: #25D366;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            text-align: center;
        }

        .btn-whatsapp:hover {
            background-color: #1DA851;
        }

        .map-container {
            margin-top: 10px;
        }

        p {
            margin-bottom: 10px;
            font-size: 16px;
        }

        h2 {
            margin-top: 20px;
            font-size: 20px;
        }
    </style>
</body>
</html>
