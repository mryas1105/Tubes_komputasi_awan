<?php
$host = 'host.docker.internal'; 
$username = 'root';
$password = '';
$database = 'tubespw';

// Membuat koneksi ke database yy
$connection = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
