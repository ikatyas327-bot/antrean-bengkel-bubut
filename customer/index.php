<?php
$path = realpath(__DIR__ . '/../koneksi.php');
if (!file_exists($path)) {
    die("File koneksi.php tidak ditemukan di: " . $path);
}
include 'koneksi.php';
if (!isset($conn)) {
    die("Koneksi database gagal. Pastikan koneksi.php menggunakan variabel \$conn");
}

$query = "SELECT * FROM menu";
$result = $conn->query($query);
?>

include '../koneksi.php'; // pastikan file koneksi sesuai path kamu

// pastikan koneksi bener-bener aktif
if (!$conn || $conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// ambil data layanan dari database
$query = "SELECT * FROM menu";
$result = $conn->query($query);
?>

// ambil data layanan dari database
$query = "SELECT * FROM menu";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-SPEED Bengkel</title>
  <link rel="stylesheet" href="../04b7ea54-f81a-47ac-9f3d-aa880d597ad9.css">
</head>
<body>
  <!-- NAVBAR -->
  <nav>
    <img src="../image/umkmlogo.png" alt="Logo E-SPEED Bengkel" style="height:50px;">
    <ul>
      <li><a href="#home">Beranda</a></li>
      <li><a href="#layanan">Layanan Unggulan</a></li>
      <li><a href="#tentang">Tentang Kami</a></li>
      <li><a href="form_ambil_antrian.php">Pesan Antrean</a></li>
    </ul>
  </nav>

  <!-- HERO SECTION -->
  <section id="home" style="
      background: url('../image/baground umkm.jpg') no-repeat center center/cover;
      height: 100vh;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;">
    <h1 style="font-size: 3rem;">Selamat Datang di <span style="color:#00ffc6;">E-SPEED</span></h1>
    <p>Spesialis Perbaikan Mesin dan Kelistrikan Motor/Mobil Anda. Cepat, Tepat, dan Bergaransi!</p>
    <a href="form_ambil_antrian.php" style="
      background-color:#00ffc6;
      color:black;
      padding:12px 28px;
      border-radius:8px;
      font-weight:bold;
      text-decoration:none;
      margin-top:20px;
      transition:0.3s;">
      Pesan Antrean Sekarang
    </a>
  </section>

  <!-- LAYANAN -->
  <section id="layanan" style="padding:80px 0;text-align:center;background-color:#f4f4f4;">
    <h2 style="margin-bottom:40px;">Layanan Unggulan Kami</h2>
    <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:24px;">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div style="background:white;border-radius:10px;padding:20px;width:260px;box-shadow:0 4px 8px rgba(0,0,0,0.1);">
          <h3><?= htmlspecialchars($row['name']) ?></h3>
          <p>Harga: Rp<?= number_format($row['price'], 0, ',', '.') ?></p>
          <p>Estimasi: <?= htmlspecialchars($row['estimated_work_time']) ?> jam</p>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <!-- TENTANG KAMI -->
  <section id="tentang" style="padding:80px;text-align:center;background-color:#222;color:white;">
    <h2>Tentang Kami</h2>
    <p style="max-width:700px;margin:20px auto;">
      E-SPEED Bengkel adalah bengkel modern yang berfokus pada pelayanan cepat, profesional,
      dan terintegrasi digital. Kami hadir untuk mempermudah pelanggan dalam melakukan
      perawatan dan perbaikan kendaraan dengan sistem antrean online yang praktis.
    </p>
  </section>

  <script src="../c5c43e88-f6a3-4d8e-a890-45d5d446cbe1.js"></script>
</body>
</html>
