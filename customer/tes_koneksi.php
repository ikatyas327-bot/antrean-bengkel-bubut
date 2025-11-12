<?php
include '../koneksi.php';

if (isset($conn)) {
    echo "<h2 style='color:green'>✅ Variabel \$conn ditemukan!</h2>";

    if ($conn->connect_error) {
        echo "<h3 style='color:red'>❌ Tapi koneksi gagal: " . $conn->connect_error . "</h3>";
    } else {
        echo "<h3 style='color:blue'>🎉 Koneksi ke database BERHASIL!</h3>";
    }
} else {
    echo "<h2 style='color:red'>❌ Variabel \$conn TIDAK ditemukan.</h2>";
}
?>
