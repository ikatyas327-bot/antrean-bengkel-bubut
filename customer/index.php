<?php
include '../koneksi.php'; // pastikan ini menunjuk ke koneksi.php utama

if (!isset($conn) || !$conn) {
    die("❌ Koneksi database gagal: variabel \$conn tidak terdefinisi.");
}
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil data layanan
$query  = "SELECT * FROM menu ORDER BY name ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-SPEED Bengkel</title>
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background-color: #f7f7f7;
    }

    /* NAVBAR */
    nav {
      background-color: #1a1a1a;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 50px;
    }

    nav img {
      height: 50px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 25px;
      margin: 0;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
      font-weight: 600;
      transition: 0.3s;
    }

    nav ul li a:hover {
      color: #00ffc6;
    }

    /* HERO */
    #home {
      background: url('../image/baground umkm.jpg') no-repeat center center/cover;
      height: 100vh;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    #home h1 {
      font-size: 3rem;
      margin-bottom: 10px;
      text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.4);
    }

    #home span {
      color: #00ffc6;
    }

    #home a {
      background-color: #00ffc6;
      color: black;
      padding: 12px 28px;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      margin-top: 20px;
      transition: 0.3s;
    }

    #home a:hover {
      background-color: #00cca3;
    }

    /* LAYANAN */
    #layanan {
      padding: 80px 0;
      text-align: center;
      background-color: #f8f8f8;
    }

    #layanan h2 {
      font-size: 2rem;
      margin-bottom: 40px;
      color: #333;
    }

    .layanan-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 25px;
    }

    .layanan-item {
      background: white;
      border-radius: 12px;
      padding: 20px;
      width: 260px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: 0.3s;
    }

    .layanan-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .layanan-item h3 {
      color: #00bfa6;
      font-size: 1.3rem;
      margin-bottom: 10px;
    }

    .layanan-item p {
      margin: 5px 0;
      color: #444;
    }

    /* FOOTER / TENTANG KAMI */
    #tentang {
      background-color: #1a1a1a;
      color: white;
      text-align: center;
      padding: 80px 20px;
    }

    #tentang h2 {
      color: #00ffc6;
    }

    #tentang p {
      max-width: 700px;
      margin: 20px auto;
      line-height: 1.6;
    }

    footer {
      background-color: #111;
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav>
    <img src="../image/umkmlogo.png" alt="Logo Bengkel">
    <ul>
      <li><a href="#home">Beranda</a></li>
      <li><a href="#layanan">Layanan</a></li>
      <li><a href="#tentang">Tentang Kami</a></li>
      <li><a href="ambil_antrian.php">Ambil Antrean</a></li>
    </ul>
  </nav>

  <!-- HERO -->
  <section id="home">
    <h1>Selamat Datang di <span>E-SPEED</span></h1>
    <p>Spesialis Perbaikan Mesin dan Kelistrikan Motor/Mobil Anda.<br>Cepat, Tepat, dan Bergaransi!</p>
    <a href="ambil_antrian.php">Pesan Antrean Sekarang</a>
  </section>

  <!-- LAYANAN -->
  <section id="layanan">
    <h2>Layanan Unggulan Kami</h2>
    <div class="layanan-container">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="layanan-item">
            <h3><?= htmlspecialchars($row['name']) ?></h3>
            <p>Harga: Rp<?= number_format($row['price'], 0, ',', '.') ?></p>
            <p>Estimasi: <?= htmlspecialchars($row['estimated_work_time']) ?> jam</p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Tidak ada layanan tersedia.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- TENTANG KAMI -->
  <section id="tentang">
    <h2>Tentang Kami</h2>
    <p>E-SPEED Bengkel adalah bengkel modern yang berfokus pada pelayanan cepat, profesional,
      dan terintegrasi digital. Kami hadir untuk mempermudah pelanggan dalam melakukan
      perawatan dan perbaikan kendaraan dengan sistem antrean online yang praktis.</p>
  </section>

  <footer>
    &copy; <?= date("Y") ?> E-SPEED Bengkel | All Rights Reserved.
  </footer>

</body>
</html>
