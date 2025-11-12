<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "umkm_bengkel_bubut_new"; // pastikan sesuai dengan nama database kamu

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
