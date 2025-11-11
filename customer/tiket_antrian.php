<?php
include "koneksi.php";

if (!isset($_GET['antrian'])) {
    header("Location: index.php");
    exit;
}

$queue_number = $_GET['antrian'];

$q = $conn->query("SELECT q.*, m.name AS nama_layanan, m.estimated_work_time 
                   FROM queue q 
                   JOIN menu m ON q.id_menu = m.id_menu
                   WHERE q.queue_number = '$queue_number'");

$data = $q->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Antrian - <?= $data['queue_number']; ?></title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background: var(--bg-secondary);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .ticket {
            background: #fff;
            width: 420px;
            padding: 25px;
            border-radius: 14px;
            text-align: center;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--metal-1);
        }

        .ticket h1 {
            font-size: 42px;
            margin-bottom: 5px;
            color: var(--primary-dark);
        }

        .ticket h2 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .ticket p {
            font-size: 16px;
            margin: 6px 0;
        }

        .ticket .label {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .ticket .btn-group {
            margin-top: 18px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-print, .btn-wa {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-print {
            background: var(--primary-dark);
            color: white;
        }

        .btn-print:hover {
            background: var(--primary-light);
        }

        .btn-wa {
            background: #25D366;
            color: white;
        }

        .btn-wa:hover {
            background: #1cae54;
        }
    </style>
</head>

<body>

<div class="ticket">
    <h1><?= $data['queue_number']; ?></h1>
    <h2><?= $data['nama_layanan']; ?></h2>

    <p><span class="label">Nama:</span> <?= $data['nama']; ?></p>
    <p><span class="label">Telepon:</span> <?= $data['telepon']; ?></p>
    <p><span class="label">Prioritas:</span> <?= $data['priority']; ?></p>
    <p><span class="label">Status:</span> <?= $data['status']; ?></p>
    <p><span class="label">Tanggal:</span> <?= $data['tanggal']; ?></p>

    <div class="btn-group">
        <button class="btn-print" onclick="window.print()">Print</button>

        <?php
        $pesanWA = urlencode("Halo, saya ingin menanyakan antrian saya:\n\nNomor: {$data['queue_number']}\nLayanan: {$data['nama_layanan']}\nNama: {$data['nama']}\nPrioritas: {$data['priority']}\n\nTerima kasih!");
        ?>
        <a href="https://wa.me/?text=<?= $pesanWA; ?>" target="_blank">
            <button class="btn-wa">Kirim WA</button>
        </a>
    </div>
</div>

</body>
</html>
