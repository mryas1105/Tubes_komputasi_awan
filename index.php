<?php
session_start();
include("connection.php");
include("conn.php");
// perintah untuk logout
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Fungsi pencarian
$search_results = array(); // Inisialisasi array untuk hasil pencarian

if (isset($_POST["search"])) {
    // Ambil kata kunci pencarian
    $search_keyword = htmlentities(strip_tags(trim($_POST["search_keyword"])));

    // Validasi apakah kata kunci tidak kosong
    if (!empty($search_keyword)) {
        // Lakukan pencarian sesuai kebutuhan, misalnya pada tabel mobil
        $query = "SELECT * FROM mobil WHERE nama_mobil LIKE '%$search_keyword%'";
        $result = mysqli_query($connection, $query);

        // memriksa kesalahan dalam query
        if (!$result) {
            die("Query error: " . mysqli_error($connection));
        }

        // Ambil hasil pencarian dan simpan ke dalam array
        while ($row = mysqli_fetch_assoc($result)) {
            $search_results[] = $row;
        }

        // Bebaskan hasil query
        mysqli_free_result($result);
    } else {
        // Tambahkan pesan error jika kata kunci kosong
        $_SESSION["error_message"] = "Masukkan kata kunci pencarian.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speedster Motors</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

    <!-- - custom css link  -->
    <link rel="stylesheet" href="css/style_sakkarepmu.css">

    <!-- - google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>

<body>
    <?php
    include 'components/header.php';
    ?>
    <div class="banner">

        <div class="container">

            <div class="slider-container has-scrollbar">

                <div class="slider-item">

                    <img src="./uploads/Screenshot 2024-12-22 171310.png" alt="Jawir Cars" class="banner-img">

                    <div class="banner-content">

                        <p class="banner-subtitle">Trending item</p>

                        <h2 class="banner-title">Speedster Motors</h2>

                        <a href="merek.php" class="banner-btn">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>
        <div class="product-container">
            <div class="container">
                <!-- KATEGORI KIRI -->
                <div class="sidebar  has-scrollbar" data-mobile-menu>

                    <div class="sidebar-top">
                        <h2 class="sidebar-title">KATEGORI</h2>

                        <button class="sidebar-close-btn" data-mobile-menu-close-btn>
                            <ion-icon name="close-outline"></ion-icon>
                        </button>
                    </div>
                    <div class="sidebar-category">
                        <?php
                        $select_mobil = $conn->prepare("SELECT DISTINCT merek FROM mobil LIMIT 5");
                        $select_mobil->execute();
                        if ($select_mobil->rowCount() > 0) {
                            while ($fetch_mobil = $select_mobil->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <ul class="sidebar-menu-category-list">

                                    <li class="sidebar-menu-category">

                                        <button class="sidebar-accordion-menu" data-accordion-btn>
                                            <form action="" method="post" class="swiper-slide slide">
                                                <div class="menu-title-flex">
                                                    <!-- <img src="./assets/images/icons/dress." alt="clothes" width="20" height="20" class="menu-title-img"> -->
                                                    <input type="hidden" name="merk" value="<?= $fetch_mobil['merek']; ?>">
                                                    <a class="menu-title" href="merek.php?brand=<?= $fetch_mobil['merek']; ?>"><?= $fetch_mobil['merek']; ?></a>
                                                </div>
                                            </form>

                                        </button>

                                        <ul class="sidebar-submenu-category-list" data-accordion>

                                            <li class="sidebar-submenu-category">
                                                <a href="#" class="sidebar-submenu-title">
                                                    <p class="product-name">Shirt</p>
                                                    <data value="300" class="stock" title="Available Stock">300</data>
                                                </a>
                                            </li>

                                            <li class="sidebar-submenu-category">
                                                <a href="#" class="sidebar-submenu-title">
                                                    <p class="product-name">shorts & jeans</p>
                                                    <data value="60" class="stock" title="Available Stock">60</data>
                                                </a>
                                            </li>

                                            <li class="sidebar-submenu-category">
                                                <a href="#" class="sidebar-submenu-title">
                                                    <p class="product-name">jacket</p>
                                                    <data value="50" class="stock" title="Available Stock">50</data>
                                                </a>
                                            </li>

                                            <li class="sidebar-submenu-category">
                                                <a href="#" class="sidebar-submenu-title">
                                                    <p class="product-name">dress & frock</p>
                                                    <data value="87" class="stock" title="Available Stock">87</data>
                                                </a>
                                            </li>

                                        </ul>

                                    </li>
                                    <!--  -->
                                </ul>
                        <?php
                            }
                        } else {
                            echo '<p class="empty">no products added yet!</p>';
                        }
                        ?>
                    </div>


                </div>
                <?php
                
                // Tampilkan pesan kesalahan jika ada
                if (isset($_SESSION["error_message"])) {
                    echo "<div class='error'>{$_SESSION["error_message"]}</div>";
                    unset($_SESSION["error_message"]);
                }
                ?>


                <!-- product -->
                <div class="product-main">

                    <h2 class="title">New Products</h2>

                    <div class="product-grid">

                        <?php
                        $select_mobil = $conn->prepare("SELECT * FROM `mobil` LIMIT 8");
                        $select_mobil->execute();
                        if ($select_mobil->rowCount() > 0) {
                            while ($fetch_mobil = $select_mobil->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <form action="" method="post" class="swiper-slide slide">
                                    <div class="showcase">
                                        <div class="showcase-banner">
                                            <!-- gawe post (array key) -->
                                            <input type="hidden" name="pid" value="<?= $fetch_mobil['id']; ?>">
                                            <input type="hidden" name="name" value="<?= $fetch_mobil['nama_mobil']; ?>">
                                            <img src="/<?= $fetch_mobil['gambar']; ?>" alt="mobel" width="300" class="product-img default">
                                            <img src="/<?= $fetch_mobil['gambar']; ?>" alt="mobel" width="300" class="product-img hover">
                                            <input type="hidden" name="merek" value="<?= $fetch_mobil['merek']; ?>">



                                            <!-- <p class="showcase-badge">TESTING</p> -->
                                            <div href="detail_mobil.php?id=<?= $fetch_mobil['id']; ?>" class="showcase-actions">

                                                <a href="detail_mobil.php?id=<?= $fetch_mobil['id']; ?>" class="btn-action">
                                                    <ion-icon href="detail_mobil.php?id=<?= $fetch_mobil['id']; ?>" name="eye-outline"></ion-icon>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="showcase-content">
                                            <a href="#" class="showcase-category"><?= $fetch_mobil['merek']; ?></a>
                                            <a href="detail_mobil.php?id=<?= $fetch_mobil['id']; ?>">
                                                <h3 class="showcase-title"><?= $fetch_mobil['nama_mobil']; ?></h3>
                                                <!-- <h3 class="showcase-isilur">sdsdsd</h3> -->
                                            </a>
                                        </div>
                                    </div>
                                    <!-- <input type="submit" value="tambahkan ke keranjang" class="btn btn-login" name="add_to_cart"> -->

                                </form>
                        <?php
                            }
                        } else {
                            echo '<p class="empty">no products added yet!</p>';
                        }
                        ?>

                    </div>

                </div>

            </div>

            <!-- end -->


        </div>
        </div>
        <!-- product container -->
    </main>

</body>

</html>