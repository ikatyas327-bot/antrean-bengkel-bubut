<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ambil Antrian - E-SPEED</title>
  <link rel="stylesheet" href="../04b7ea54-f81a-47ac-9f3d-aa880d597ad9.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f5f5f5; padding: 20px; }
    .container { max-width: 600px; background: #fff; padding: 20px; margin: auto; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
    h2 { text-align: center; margin-bottom: 20px; }
    label { display: block; margin-top: 12px; font-weight: 600; }
    input, textarea, select {
      width: 100%; padding: 10px; margin-top: 6px;
      border-radius: 8px; border: 1px solid #ccc; outline: none;
    }
    button {
      margin-top: 20px; width: 100%;
      background: #00ffc6; color: #000;
      padding: 12px; border: none; border-radius: 8px; font-weight: 700;
      transition: 0.2s;
    }
    button:hover { background: #00b88a; color: #fff; }
    .wa {
      display: block; text-align: center; margin-top: 15px; color: #007b00;
      text-decoration: none; font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Form Ambil Antrian</h2>
    <form action="simpan_antrian.php" method="POST">
      <label>Nama Anda</label>
      <input type="text" name="nama" required>

      <label>No. Telepon</label>
      <input type="text" name="telepon" required>

      <label>Alamat</label>
      <textarea name="alamat" rows="2" required></textarea>

      <label>Layanan</label>
      <select name="id_menu" required>
        <option value="">-- Pilih Layanan --</option>
        <?php
          $layanan = $conn->query("SELECT id_menu, name FROM menu");
          while ($l = $layanan->fetch_assoc()) {
            echo "<option value='{$l['id_menu']}'>{$l['name']}</option>";
          }
        ?>
        <option value="lainnya">Lainnya</option>
      </select>

      <label>Keluhan / Detail</label>
      <textarea name="keluhan" rows="2" placeholder="Jelaskan masalah kendaraan Anda"></textarea>

      <label>Prioritas</label>
      <select name="priority" required>
        <option value="Normal">Normal</option>
        <option value="Urgent">Urgent</option>
        <option value="Low">Low</option>
      </select>

      <button type="submit">Ambil Antrian</button>
    </form>

    <a class="wa" href="https://wa.me/628993322514?text=Halo%20Admin,%20saya%20ingin%20konsultasi%20tentang%20layanan%20lainnya." target="_blank">
      💬 Konsultasi dengan Admin via WhatsApp
    </a>
  </div>
</body>
</html>
