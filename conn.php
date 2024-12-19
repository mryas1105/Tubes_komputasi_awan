<?php
$host = 'host.docker.internal'; 
$username = 'root';
$password = ''; 
$database = 'tubespw'; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Hapus output berikut untuk mencegah masalah header
    // echo "Connected to the database successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
