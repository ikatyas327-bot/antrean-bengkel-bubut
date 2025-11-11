<?php
// koneksi.php - taruh di root project
$host = '127.0.0.1';
$user = 'root';
$pass = '';           // isi kalau kamu pakai password
$db   = 'umkm_bengkel_bubut_new';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die("Koneksi gagal: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
return $mysqli;
