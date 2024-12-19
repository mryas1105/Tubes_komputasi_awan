<?php
session_start();
include("connection.php");

// Fungsi pendaftaran
if (isset($_POST["signup"])) {
    $signup_username = htmlentities(strip_tags(trim($_POST["signup_username"])));
    $signup_password = htmlentities(strip_tags(trim($_POST["signup_password"])));

    $signup_error_message = "";

    // Validasi data
    if (empty($signup_username)) {
        $signup_error_message .= "- Username belum diisi <br>";
    }

    if (empty($signup_password)) {
        $signup_error_message .= "- Password belum diisi <br>";
    }

    // Cek apakah username sudah digunakan
    $check_username_query = "SELECT * FROM users WHERE username = '$signup_username'";
    $check_username_result = mysqli_query($connection, $check_username_query);

    if (mysqli_num_rows($check_username_result) > 0) {
        $signup_error_message .= "- Username sudah digunakan <br>";
    }

    if ($signup_error_message === "") {
        // Tambahkan data ke database dengan password_hash
        $hashed_password = password_hash($signup_password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (username, password, role) VALUES ('$signup_username', '$hashed_password', 'user')";
        mysqli_query($connection, $insert_query);

        $_SESSION["role"] = 'user'; // Set role sebagai 'user'
        header("Location: index.php");
    }
}

// Mengarahkan pengguna ke halaman login
if (isset($_POST["login_redirect"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup.css">
</head>

<body>
    <div class="container">
        <h1>Sign Up</h1>
        <?php
        if (isset($signup_error_message) && $signup_error_message !== "") {
            echo "<div class='error'>$signup_error_message</div>";
        }
        ?>

        <form action="signup.php" method="post">
            <fieldset>
                <legend>Sign Up</legend>
                <p>
                    <label for="signup_username">Username : </label>
                    <input type="text" name="signup_username" id="signup_username" value="<?php echo isset($signup_username) ? $signup_username : '' ?>">
                </p>
                <p>
                    <label for="signup_password">Password : </label>
                    <input type="password" name="signup_password" id="signup_password" value="<?php echo isset($signup_password) ? $signup_password : '' ?>">
                </p>
                <p>
                    <input type="submit" name="signup" value="Sign Up">
                </p>
                <p>
                    <!-- Tautan atau tombol ke halaman login -->
                    <button type="submit" name="login_redirect">Login</button>
                </p>
            </fieldset>
        </form>

    </div>
</body>

</html>
