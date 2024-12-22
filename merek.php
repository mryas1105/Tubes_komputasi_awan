<?php
session_start();
include("connection.php");
include("conn.php");

// Ambil merek dari parameter URL
if (isset($_GET['brand'])) {
    $selected_brand = urldecode($_GET['brand']);

    // Query untuk mendapatkan mobil berdasarkan merek
    $query_mobil_merek = "SELECT * FROM mobil WHERE merek = '$selected_brand'";
    $result_mobil_merek = mysqli_query($connection, $query_mobil_merek);

    // Periksa kesalahan dalam query
    if (!$result_mobil_merek) {
        die("Query error: " . mysqli_error($connection));
    }

    // Ambil hasil pencarian dan simpan ke dalam array
    $mobil_merek_results = array();
    while ($row_merek = mysqli_fetch_assoc($result_mobil_merek)) {
        $mobil_merek_results[] = $row_merek;
    }

    // Bebaskan hasil query
    mysqli_free_result($result_mobil_merek);
} else {
    // Jika tidak ada merek yang dipilih, kembalikan ke halaman utama
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anon - eCommerce Website</title>

    <!--
    - favicon
  -->
    <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

    <!--
    - custom css link
  -->
    <link rel="stylesheet" href="css/style_sakkarepmu.css">

    <!--
    - google font link
  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>

<body>

    <?php
    include 'components/header.php';
    ?>
    <main>
        <div class="product-container">
            <div class="container">
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
                                            <!-- <div>
                            <ion-icon name="add-outline" class="add-icon"></ion-icon>
                            <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                        </div> -->

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
                <!-- end kategori -->
                <!-- product -->
                <div class="product-main">

                    <h2 class="title">New Products</h2>

                    <div class="product-grid">

                        <?php
                        $select_mobil = $conn->prepare("SELECT * FROM mobil WHERE merek = '$selected_brand'");
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

                <!--  -->

            </div>
        </div>
    </main>
</body>

</html>