<?php
ob_start(); // Memulai output buffering
session_start();
include("connection.php");

// Initialize variables for error message and username
$error_message = "";
$username = "";

// Fungsi login
if (isset($_POST["submit"])) {
    // Sanitize and trim inputs
    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $password = htmlentities(strip_tags(trim($_POST["password"])));

    // Validate inputs
    if (empty($username)) {
        $error_message .= "- Username belum diisi <br>";
    }

    if (empty($password)) {
        $error_message .= "- Password belum diisi <br>";
    }

    // Check if any error exists before proceeding
    if (empty($error_message)) {
        // Check admin credentials
        $admin_username = "admin";
        $admin_password = "admin123";

        if ($username === $admin_username && $password === $admin_password) {
            // Save role admin in session
            $_SESSION["role"] = 'admin';
            header("Location: admin.php");
            exit();
        } else {
            // Check regular user credentials in the database using prepared statement
            $query = "SELECT id, username, password, role FROM users WHERE username = ?";
            if ($stmt = mysqli_prepare($connection, $query)) {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                // Check if username exists
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id, $db_username, $db_password, $userRole);
                    mysqli_stmt_fetch($stmt);

                    // Verify password using password_verify
                    if (password_verify($password, $db_password)) {
                        // Save role and user ID in session
                        $_SESSION["role"] = $userRole;
                        $_SESSION["id"] = $user_id;

                        // Redirect based on user role
                        if ($userRole === 'admin') {
                            header("Location: admin.php");
                            exit();
                        } elseif ($userRole === 'user') {
                            header("Location: index.php");
                            exit();
                        }
                    } else {
                        $error_message .= "- Username dan/atau Password tidak sesuai <br>";
                    }
                } else {
                    $error_message .= "- Username dan/atau Password tidak sesuai <br>";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            } else {
                $error_message .= "- Terjadi kesalahan pada query. <br>";
            }
        }
    }
}

// Redirect to signup page if signup button is clicked
if (isset($_POST["signup"])) {
    header("Location: signup.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <?php
        if ($error_message !== "") {
            echo "<div class='error'>$error_message</div>";
        }
        ?>
        <form action="login.php" method="post">
            <fieldset>
                <legend>Login</legend>
                <p>
                    <label for="username">Username : </label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </p>
                <p>
                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password" required>
                </p>
                <p>
                    <input type="submit" name="submit" value="Log In">
                </p>
                <p>
                    <a href="index.php">Kembali Ke Home</a>
                </p>
            </fieldset>
        </form>

        <form action="login.php" method="post">
            <fieldset>
                <legend>Sign Up</legend>
                <p>
                    <input type="submit" name="signup" value="Sign Up">
                </p>
            </fieldset>
        </form>
    </div>
</body>
</html>

<?php ob_end_flush(); // Mengakhiri output buffering ?>
