<?php

include("connection.php");

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



<div class="overlay" data-overlay></div>


<header class="header">
    <section class="flex">
        <div class="header-top">
            <div class="container">
                <ul class="header-social-container">
                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-facebook"></ion-icon>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-twitter"></ion-icon>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-instagram"></ion-icon>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-linkedin"></ion-icon>
                        </a>
                    </li>
                </ul>
                <div class="header-alert-news">
                    <p>
                       
                        KETINTANG - WONOKROMO
                    </p>
                </div>
                <div class="header-top-actions">
                    <select name="currency">
                        <option value="usd">IDR</option>
                        <option value="eur">EUR &euro;</option>
                    </select>
                    <select name="language">
                        <option value="en-US">Indonesia</option>
                        <option value="es-ES">Espa&ntilde;ol</option>
                        <option value="fr">Fran&ccedil;ais</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="header-main">

            <div class="container">

                <a href="index.php" class="header-logo">
                    <img src="/uploads/logo.png" alt="logo" width="120" height="50">
                    <!-- <img src="./assets/images/logo/telu.png" alt="Jawir.In's logo" width="120" height="36"> -->
                </a>
                <div class="header-search-container">
               <!-- search query -->
            <?php
               if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
                  $search_box = $_POST['search_box'];
                  $select_mobil = $conn->prepare("SELECT * FROM `mobil` WHERE nama_mobil LIKE '%{$search_box}%'");
                  $select_mobil->execute();
                  if ($select_mobil->rowCount() > 0) {
                     while ($fetch_mobil = $select_mobil->fetch(PDO::FETCH_ASSOC)) {
               ?>
                      
               <?php
                     }
                  } else {
                     echo '<p class="empty">tidak ada produk yang ditemukan!</p>';
                  }
               }
               ?>

               <!-- end -->
               <!-- <section class="search-form">
                  <form action="" method="post">
                     <input type="text" name="search_box" placeholder="cari produk..." maxlength="100" class="box" required>
                     <button type="submit" class="fas fa-search" name="search_btn"></button>
                  </form>
               </section> -->
               <section class="search-form">
               <form action="" method="post">
                  <input type="text" name="search_box" class="search-field" placeholder="Masukan Nama Produk..." required>

                  <button class="search-btn" name="search_btn">
                     <ion-icon name="search-outline" ></ion-icon>
                  </button>
               </form>
               </section>
            </div> 

                <?php
                // Tampilkan formulir login atau tautan ke login.php jika pengguna belum login
                if (!isset($_SESSION["role"]) || ($_SESSION["role"] !== 'admin' && $_SESSION["role"] !== 'user')) {
                ?>
                    <a href="login.php" class="btn btn-login">Login</a>
                    <!-- <p>Belum punya akun? <a href="signup.php">Daftar disini</a></p> -->
                <?php
                } else {
                    // Pengguna sudah login, tampilkan tombol logout
                ?>
                    <form action="index.php" method="post">
                        <input type="submit" name="logout" value="Logout" class="btn btn-logout">
                    </form>
                <?php
                }
                ?>

            </div>
        </div>
        <nav class="desktop-navigation-menu">

            <div class="container">

          <!-- code -->

            </div>

        </nav>

        <div class="mobile-bottom-navigation">

            <button class="action-btn" data-mobile-menu-open-btn>
                <ion-icon name="menu-outline"></ion-icon>
            </button>

            <button class="action-btn">
                <ion-icon name="bag-handle-outline"></ion-icon>

                <span class="count">0</span>
            </button>

            <button class="action-btn">
                <ion-icon name="home-outline"></ion-icon>
            </button>

            <button class="action-btn">
                <ion-icon name="heart-outline"></ion-icon>

                <span class="count">0</span>
            </button>

            <button class="action-btn" data-mobile-menu-open-btn>
                <ion-icon name="grid-outline"></ion-icon>
            </button>

        </div>

        <nav class="mobile-navigation-menu  has-scrollbar" data-mobile-menu>

            <div class="menu-top">
                <h2 class="menu-title">Menu</h2>

                <button class="menu-close-btn" data-mobile-menu-close-btn>
                    <ion-icon name="close-outline"></ion-icon>
                </button>
            </div>

            <ul class="mobile-menu-category-list">

                <li class="menu-category">
                    <a href="#" class="menu-title">Home</a>
                </li>

                <li class="menu-category">

                    <button class="accordion-menu" data-accordion-btn>
                        <p class="menu-title">Men's</p>

                        <div>
                            <ion-icon name="add-outline" class="add-icon"></ion-icon>
                            <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                        </div>
                    </button>

                    <ul class="submenu-category-list" data-accordion>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Shirt</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Shorts & Jeans</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Safety Shoes</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Wallet</a>
                        </li>

                    </ul>

                </li>

                <li class="menu-category">

                    <button class="accordion-menu" data-accordion-btn>
                        <p class="menu-title">Women's</p>

                        <div>
                            <ion-icon name="add-outline" class="add-icon"></ion-icon>
                            <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                        </div>
                    </button>

                    <ul class="submenu-category-list" data-accordion>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Dress & Frock</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Earrings</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Necklace</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Makeup Kit</a>
                        </li>

                    </ul>

                </li>

                <li class="menu-category">

                    <button class="accordion-menu" data-accordion-btn>
                        <p class="menu-title">Jewelry</p>

                        <div>
                            <ion-icon name="add-outline" class="add-icon"></ion-icon>
                            <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                        </div>
                    </button>

                    <ul class="submenu-category-list" data-accordion>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Earrings</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Couple Rings</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Necklace</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Bracelets</a>
                        </li>

                    </ul>

                </li>

                <li class="menu-category">

                    <button class="accordion-menu" data-accordion-btn>
                        <p class="menu-title">Perfume</p>

                        <div>
                            <ion-icon name="add-outline" class="add-icon"></ion-icon>
                            <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                        </div>
                    </button>

                    <ul class="submenu-category-list" data-accordion>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Clothes Perfume</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Deodorant</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Flower Fragrance</a>
                        </li>

                        <li class="submenu-category">
                            <a href="#" class="submenu-title">Air Freshener</a>
                        </li>

                    </ul>

                </li>

                <li class="menu-category">
                    <a href="#" class="menu-title">Blog</a>
                </li>

                <li class="menu-category">
                    <a href="#" class="menu-title">Hot Offers</a>
                </li>

            </ul>

            <div class="menu-bottom">

                <ul class="menu-category-list">

                    <li class="menu-category">

                        <button class="accordion-menu" data-accordion-btn>
                            <p class="menu-title">Language</p>

                            <ion-icon name="caret-back-outline" class="caret-back"></ion-icon>
                        </button>

                        <ul class="submenu-category-list" data-accordion>

                            <li class="submenu-category">
                                <a href="#" class="submenu-title">Indonesia</a>
                            </li>

                            <li class="submenu-category">
                                <a href="#" class="submenu-title">Espa&ntilde;ol</a>
                            </li>

                            <li class="submenu-category">
                                <a href="#" class="submenu-title">Fren&ccedil;h</a>
                            </li>

                        </ul>

                    </li>

                    <li class="menu-category">
                        <button class="accordion-menu" data-accordion-btn>
                            <p class="menu-title">Currency</p>
                            <ion-icon name="caret-back-outline" class="caret-back"></ion-icon>
                        </button>

                        <ul class="submenu-category-list" data-accordion>
                            <li class="submenu-category">
                                <a href="#" class="submenu-title">IDR</a>
                            </li>

                            <li class="submenu-category">
                                <a href="#" class="submenu-title">EUR &euro;</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>

        </nav>
    </section>

    <script src="./assets/js/script.js"></script>
    <!--- ionicon link-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</header>