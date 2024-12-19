<?php
session_start();
include("connection.php");

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $mobil_id_edit = $_GET['id'];

    // Fetch car details based on ID
    $query_edit = "SELECT * FROM mobil WHERE id = $mobil_id_edit";
    $result_edit = mysqli_query($connection, $query_edit);

    // Fetch the list of producers for the dropdown
    $query_produsen = "SELECT * FROM produsen";
    $result_produsen = mysqli_query($connection, $query_produsen);

    // Check if the query is successful
    if ($result_edit && $result_produsen) {
        $row_edit = mysqli_fetch_assoc($result_edit);
    } else {
        echo "Error: " . mysqli_error($connection);
        exit();
    }
} else {
    // If ID is not set, redirect to admin.php or handle accordingly
    header("Location: admin.php");
    exit();
}

// Handle form submission for updating data
if (isset($_POST['update'])) {
    $nama_mobil_baru = mysqli_real_escape_string($connection, $_POST['nama_mobil_baru']);
    $merek_baru = mysqli_real_escape_string($connection, $_POST['merek_baru']);
    $model_baru = mysqli_real_escape_string($connection, $_POST['model_baru']);
    $tahun_mobil_baru = mysqli_real_escape_string($connection, $_POST['tahun_mobil_baru']);
    $produsen_id = mysqli_real_escape_string($connection, $_POST['produsen_id']);

    // Check if a new image is provided
    if ($_FILES['gambar_mobil']['error'] == 0) {
        // Delete the existing image file
        unlink($row_edit['gambar']);

        // Upload and move the new image file
        $gambar_mobil_name = $_FILES['gambar_mobil']['name'];
        $gambar_mobil_tmp = $_FILES['gambar_mobil']['tmp_name'];
        $gambar_mobil_destination = 'uploads/' . uniqid('img_') . '_' . $gambar_mobil_name;
        move_uploaded_file($gambar_mobil_tmp, $gambar_mobil_destination);

        // Update data with the new image path
        $query_update = "UPDATE mobil SET nama_mobil='$nama_mobil_baru', merek='$merek_baru', model='$model_baru', tahun='$tahun_mobil_baru', gambar='$gambar_mobil_destination', produsen_id='$produsen_id' WHERE id=$mobil_id_edit";
    } else {
        // Update data without changing the image
        $query_update = "UPDATE mobil SET nama_mobil='$nama_mobil_baru', merek='$merek_baru', model='$model_baru', tahun='$tahun_mobil_baru', produsen_id='$produsen_id' WHERE id=$mobil_id_edit";
    }

    // Check if the query is successful
    if (mysqli_query($connection, $query_update)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <div class="container">
        <h1>Edit Data Mobil</h1>

        <!-- Tabel untuk menampilkan data mobil -->
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nama Mobil</th>
                <th>Merek</th>
                <th>Model</th>
                <th>Tahun</th>
                <th>Gambar</th>
            </tr>
            <tr>
                <td><?php echo $row_edit['id']; ?></td>
                <td><?php echo $row_edit['nama_mobil']; ?></td>
                <td><?php echo $row_edit['merek']; ?></td>
                <td><?php echo $row_edit['model']; ?></td>
                <td><?php echo $row_edit['tahun']; ?></td>
                <td><img src="<?php echo $row_edit['gambar']; ?>" alt="Gambar Mobil" style="max-width: 100px;"></td>
            </tr>
        </table>

        <!-- Formulir untuk mengedit data -->
        <form action="edit_data.php?id=<?php echo $mobil_id_edit; ?>" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Edit Data</legend>
                <p>
                    <label for="nama_mobil_baru">Nama Mobil Baru: </label>
                    <input type="text" name="nama_mobil_baru" id="nama_mobil_baru" value="<?php echo $row_edit['nama_mobil']; ?>" required>
                </p>
                <p>
                    <label for="merek_baru">Merek Baru: </label>
                    <input type="text" name="merek_baru" id="merek_baru" value="<?php echo $row_edit['merek']; ?>" required>
                </p>
                <p>
                    <label for="model_baru">Model Baru: </label>
                    <input type="text" name="model_baru" id="model_baru" value="<?php echo $row_edit['model']; ?>" required>
                </p>
                <p>
                    <label for="tahun_mobil_baru">Tahun Mobil Baru: </label>
                    <input type="text" name="tahun_mobil_baru" id="tahun_mobil_baru" value="<?php echo $row_edit['tahun']; ?>" required>
                </p>
                <p>
                    <label for="produsen_id">Produsen:</label>
                    <select name="produsen_id" id="produsen_id" required>
                        <?php
                        while ($row_produsen = mysqli_fetch_assoc($result_produsen)) {
                            $selected = ($row_produsen['id'] == $row_edit['produsen_id']) ? 'selected' : '';
                            echo "<option value='{$row_produsen['id']}' $selected>{$row_produsen['nama_produsen']}</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="gambar_mobil">Gambar Mobil Baru: </label>
                    <input type="file" name="gambar_mobil" id="gambar_mobil" accept="image/*">
                </p>
                <input type="submit" name="update" value="Update">
            </fieldset>
        </form>

        <!-- Link kembali ke admin.php -->
        <p><a href="admin.php">Kembali ke Admin Page</a></p>
    </div>
</body>

</html>
