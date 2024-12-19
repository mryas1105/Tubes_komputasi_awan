<?php
session_start();
include("connection.php");

// Periksa apakah pengguna memiliki hak admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Tambahkan data baru
if (isset($_POST['tambah'])) {
    $id_mobil_baru = mysqli_real_escape_string($connection, $_POST['id_mobil_baru']);
    $nama_mobil_baru = mysqli_real_escape_string($connection, $_POST['nama_mobil_baru']);
    $merek_baru = mysqli_real_escape_string($connection, $_POST['merek_baru']);
    $model_baru = mysqli_real_escape_string($connection, $_POST['model_baru']);
    $tahun_mobil_baru = mysqli_real_escape_string($connection, $_POST['tahun_mobil_baru']);
    $produsen_id = mysqli_real_escape_string($connection, $_POST['produsen_id']);

    // Unggah gambar
    $gambar_mobil_name = $_FILES['gambar_mobil']['name'];
    $gambar_mobil_tmp = $_FILES['gambar_mobil']['tmp_name'];
    $gambar_mobil_type = $_FILES['gambar_mobil']['type'];
    $gambar_mobil_size = $_FILES['gambar_mobil']['size'];
    $gambar_mobil_error = $_FILES['gambar_mobil']['error'];

    // Tentukan lokasi penyimpanan gambar (disesuaikan dengan kebutuhan Anda)
    $upload_directory = 'uploads/'; // Folder untuk menyimpan gambar

    // Buat nama unik untuk gambar (sehingga tidak ada yang tertimpa)
    $gambar_mobil_destination = $upload_directory . uniqid('img_') . '_' . $gambar_mobil_name;

    // Pindahkan gambar ke folder tujuan
    move_uploaded_file($gambar_mobil_tmp, $gambar_mobil_destination);

    // Tambahkan data baru ke tabel mobil
    $query_tambah_mobil = "INSERT INTO mobil (id, nama_mobil, merek, model, tahun, gambar, produsen_id) 
                     VALUES ('$id_mobil_baru', '$nama_mobil_baru', '$merek_baru', '$model_baru', '$tahun_mobil_baru', '$gambar_mobil_destination', '$produsen_id')";

    // Periksa apakah kueri berhasil dijalankan
    if (mysqli_query($connection, $query_tambah_mobil)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Tambahkan data baru produsen
if (isset($_POST['tambah_produsen'])) {
    $nama_produsen_baru = mysqli_real_escape_string($connection, $_POST['nama_produsen_baru']);
    $alamat_produsen_baru = mysqli_real_escape_string($connection, $_POST['alamat_produsen_baru']);
    $telepon_produsen_baru = mysqli_real_escape_string($connection, $_POST['telepon_produsen_baru']);

    // Tambahkan data baru ke tabel produsen
    $query_tambah_produsen = "INSERT INTO produsen (nama_produsen, alamat_produsen, telepon_produsen) 
                 VALUES ('$nama_produsen_baru', '$alamat_produsen_baru', '$telepon_produsen_baru')";

    // Periksa apakah kueri berhasil dijalankan
    if (mysqli_query($connection, $query_tambah_produsen)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Hapus data
if (isset($_GET['hapus'])) {
    $mobil_id_hapus = $_GET['hapus'];
    // Hapus data berdasarkan ID
    $query_hapus = "DELETE FROM mobil WHERE id = $mobil_id_hapus";

    // Periksa apakah kueri berhasil dijalankan
    if (mysqli_query($connection, $query_hapus)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Logout
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}


// Tampilkan data mobil
$query_mobil = "SELECT * FROM mobil";
$result_mobil = mysqli_query($connection, $query_mobil);

// Tampilkan data mobil dengan informasi produsen
$query_mobil = "SELECT mobil.*, produsen.nama_produsen 
                FROM mobil
                JOIN produsen ON mobil.produsen_id = produsen.id";

$result_mobil = mysqli_query($connection, $query_mobil);

// Periksa apakah kueri berhasil dijalankan
if (!$result_mobil) {
    echo "Error: " . mysqli_error($connection);
    exit();
}

// Tampilkan data pembelian 
$query_pembelian = "SELECT pembelian.id, pembelian.alamat, pembelian.no_telepon, users.username, mobil.nama_mobil
                    FROM pembelian
                    JOIN users ON pembelian.user_id = users.id
                    JOIN mobil ON pembelian.mobil_id = mobil.id";
$result_pembelian = mysqli_query($connection, $query_pembelian);

// Periksa apakah kueri berhasil dijalankan
if (!$result_pembelian) {
    echo "Error: " . mysqli_error($connection);
    exit();
}

// Periksa apakah kueri berhasil dijalankan
if (!$result_mobil) {
    echo "Error: " . mysqli_error($connection);
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <div class="container">
        <h1>Admin Page</h1>

        <!-- Formulir untuk menambah data baru -->
        <form action="admin.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Tambah Data Baru</legend>
                <p>
                    <label for="id_mobil_baru">ID Mobil Baru: </label>
                    <input type="text" name="id_mobil_baru" id="id_mobil_baru" required>
                </p>
                <p>
                    <label for="nama_mobil_baru">Nama Mobil Baru: </label>
                    <input type="text" name="nama_mobil_baru" id="nama_mobil_baru" required>
                </p>
                <p>
                    <label for="merek_baru">Merek Baru: </label>
                    <input type="text" name="merek_baru" id="merek_baru" required>
                </p>
                <p>
                    <label for="model_baru">Model Baru: </label>
                    <input type="text" name="model_baru" id="model_baru" required>
                </p>
                <p>
                    <label for="tahun_mobil_baru">Tahun Mobil Baru: </label>
                    <input type="text" name="tahun_mobil_baru" id="tahun_mobil_baru" required>
                </p>
                <p>
                    <label for="gambar_mobil">Gambar Mobil: </label>
                    <input type="file" name="gambar_mobil" id="gambar_mobil" accept="image/*" required>
                </p>
                <p>
            <label for="produsen_id">Produsen:</label>
            <select name="produsen_id" id="produsen_id" required>
                <?php
                // Ambil daftar produsen dari tabel produsen
                $query_produsen = "SELECT * FROM produsen";
                $result_produsen = mysqli_query($connection, $query_produsen);

                // Tampilkan opsi produsen dalam elemen dropdown
                while ($row_produsen = mysqli_fetch_assoc($result_produsen)) {
                    echo "<option value='{$row_produsen['id']}'>{$row_produsen['nama_produsen']}</option>";
                }
                ?>
            </select>
        </p>
                <input type="submit" name="tambah" value="Tambah">
            </fieldset>
        </form>

        <!-- Formulir untuk menambah produsen -->
        <form action="admin.php" method="post">
            <fieldset>
                <legend>Tambah Produsen Baru</legend>
                <p>
                    <label for="nama_produsen_baru">Nama Produsen Baru: </label>
                    <input type="text" name="nama_produsen_baru" id="nama_produsen_baru" required>
                </p>
                <p>
                    <label for="alamat_produsen_baru">Alamat Produsen Baru: </label>
                    <textarea name="alamat_produsen_baru" id="alamat_produsen_baru" rows="3" required></textarea>
                </p>
                <p>
                    <label for="telepon_produsen_baru">Telepon Produsen Baru: </label>
                    <input type="text" name="telepon_produsen_baru" id="telepon_produsen_baru" required>
                </p>
                <input type="submit" name="tambah_produsen" value="Tambah Produsen">
            </fieldset>
        </form>



<!-- Tabel untuk menampilkan data -->
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Mobil</th>
        <th>Merek</th>
        <th>Model</th>
        <th>Tahun</th>
        <th>Gambar</th>
        <th>Produsen</th> <!-- Tambah kolom Produsen -->
        <th>Aksi</th>
    </tr>
    <?php while ($row_mobil = mysqli_fetch_assoc($result_mobil)) { ?>
        <tr>
            <td><?php echo $row_mobil['id']; ?></td>
            <td><?php echo $row_mobil['nama_mobil']; ?></td>
            <td><?php echo $row_mobil['merek']; ?></td>
            <td><?php echo $row_mobil['model']; ?></td>
            <td><?php echo $row_mobil['tahun']; ?></td>
            <td><img src="<?php echo $row_mobil['gambar']; ?>" alt="Gambar Mobil" style="max-width: 100px;"></td>
            <td><?php echo $row_mobil['nama_produsen']; ?></td> <!-- Tambah kolom Produsen -->
            <td>
                <a href="edit_data.php?id=<?php echo $row_mobil['id']; ?>">Edit</a>
                <a href="admin.php?hapus=<?php echo $row_mobil['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
    <?php } ?>
</table>




        <!-- Tabel untuk menampilkan data pembelian -->
        <h2>Data Pembelian</h2>
        <table border="1">
            <tr>
                <th>ID Pembelian</th>
                <th>Nama Pelanggan</th>
                <th>Alamat Pelanggan</th>
                <th>No Telepon</th>
                <th>Nama Mobil</th>
            </tr>
            <?php while ($row_pembelian = mysqli_fetch_assoc($result_pembelian)) { ?>
                <tr>
                    <td><?php echo $row_pembelian['id']; ?></td>
                    <td><?php echo $row_pembelian['username']; ?></td>
                    <td><?php echo $row_pembelian['alamat']; ?></td>
                    <td><?php echo $row_pembelian['no_telepon']; ?></td>
                    <td><?php echo $row_pembelian['nama_mobil']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <!-- Formulir untuk logout -->
        <form action="admin.php" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
    </div>
</body>

</html>