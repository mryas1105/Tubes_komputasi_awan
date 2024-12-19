<?php
session_start();
include("connection.php");
include("conn.php");

// Periksa apakah ID mobil diberikan di URL
if (!isset($_GET['id'])) {
    echo "<p>Mobil tidak ditemukan!</p>";
    exit();
}

$id = intval($_GET['id']);

// Query untuk mendapatkan detail mobil berdasarkan ID
$query = "SELECT * FROM mobil WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);

// Periksa apakah data ditemukan
if ($stmt->rowCount() === 0) {
    echo "<p>Mobil tidak ditemukan!</p>";
    exit();
}

// Ambil data mobil
$mobil = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mobil - <?= htmlspecialchars($mobil['nama_mobil']); ?></title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style_sakkarepmu.css">
</head>
<body>
    <?php include 'components/header.php'; ?>

    <div class="container">
        <div class="detail-container">
            <div class="detail-image">
                <img src="/<?= htmlspecialchars($mobil['gambar']); ?>" alt="<?= htmlspecialchars($mobil['nama_mobil']); ?>" width="500">
            </div>

            <div class="detail-info">
                <h1><?= htmlspecialchars($mobil['nama_mobil']); ?></h1>
                <p><strong>Merek:</strong> <?= htmlspecialchars($mobil['merek']); ?></p>


                <form action="<?= isset($_SESSION['role']) ? 'halaman_pembelian.php' : 'login.php'; ?>" method="post">
                    <input type="hidden" name="mobil_id" value="<?= $mobil['id']; ?>">

                    <?php if (isset($_SESSION['role'])): ?>
                        <!-- Jika user sudah login -->
                        <button type="submit" class="btn btn-primary" name="go_to_purchase">Lanjut ke Pembelian</button>
                    <?php else: ?>
                        <!-- Jika user belum login -->
                        <p class="info-message">Silakan <a href="login.php">login</a> untuk melanjutkan ke pembelian.</p>
                        <button type="submit" class="btn btn-primary" name="redirect_to_login">Login untuk Membeli</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <style>
        .detail-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .detail-image img {
            max-width: 100%;
            border-radius: 10px;
        }

        .detail-info {
            max-width: 600px;
        }

        .detail-info h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .detail-info p {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .info-message {
            color: #ff0000;
            margin-top: 10px;
        }

        .info-message a {
            color: #007bff;
            text-decoration: none;
        }

        .info-message a:hover {
            text-decoration: underline;
        }
    </style>

</body>
</html>
