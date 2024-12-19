<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("connection.php");

if (isset($_POST['submit_rating'])) {
    $mobil_id = $_POST['mobil_id'];
    $rating = $_POST['rating'];
    $ulasan = $_POST['ulasan'];
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    var_dump($_SESSION);

    // Ensure you have a valid user ID in the session
    if ($user_id) {
        // Query to check if the user has already rated the car
        $check_existing_query = "SELECT * FROM rating_mobil WHERE mobil_id = $mobil_id AND user_id = $user_id";
        $result_existing = mysqli_query($connection, $check_existing_query);

        if ($result_existing) {
            if (mysqli_num_rows($result_existing) > 0) {
                // If user has already rated, do not update the existing record, add a new record instead
                $insert_query = "INSERT INTO rating_mobil (mobil_id, user_id, rating, ulasan) VALUES (?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($connection, $insert_query);
        
                if ($stmt_insert) {
                    mysqli_stmt_bind_param($stmt_insert, "iiss", $mobil_id, $user_id, $rating, $ulasan);
                    $result_insert = mysqli_stmt_execute($stmt_insert);
        
                    if (!$result_insert) {
                        die("Error inserting new rating: " . mysqli_error($connection));
                    }
                } else {
                    die("Error preparing insert statement: " . mysqli_error($connection));
                }
            } else {
                // If user hasn't rated, insert a new record
                $insert_query = "INSERT INTO rating_mobil (mobil_id, user_id, rating, ulasan) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($connection, $insert_query);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "iiss", $mobil_id, $user_id, $rating, $ulasan);
                    $result_insert = mysqli_stmt_execute($stmt);

                    if (!$result_insert) {
                        die("Error inserting rating: " . mysqli_error($connection));
                    }
                } else {
                    die("Error preparing insert statement: " . mysqli_error($connection));
                }
            }

            // Redirect back to the car details page after rating is saved
            header("Location: detail_mobil.php?id=$mobil_id");
            exit();
        } else {
            die("Error checking existing rating: " . mysqli_error($connection));
        }
    } else {
        // Redirect if there is no valid user ID in the session
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect if the form was not submitted correctly
    header("Location: index.php");
    exit();
}

?>