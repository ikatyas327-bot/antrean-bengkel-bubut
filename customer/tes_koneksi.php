<?php
include 'koneksi.php';

if (isset($conn)) {
    echo "✅ Koneksi database BERHASIL";
} else {
    echo "❌ VAR \$conn TIDAK ADA";
}
?>
