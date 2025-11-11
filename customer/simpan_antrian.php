<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'koneksi.php'; // ✅ perbaikan path

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama       = $_POST['nama'];
    $telepon    = $_POST['telepon'];
    $alamat     = $_POST['alamat'];
    $keluhan    = $_POST['keluhan'];
    $id_menu    = $_POST['id_menu'];
    $priority   = $_POST['priority'];

    // ===== 1. Generate Customer ID =====
    $result = $conn->query("SELECT customer_id FROM customer ORDER BY customer_id DESC LIMIT 1");
    if ($result->num_rows > 0) {
        $lastID = $result->fetch_assoc()['customer_id'];
        $num = (int) substr($lastID, 1) + 1;
        $customerID = "C" . str_pad($num, 5, "0", STR_PAD_LEFT);
    } else {
        $customerID = "C00001";
    }

    // ===== 2. Simpan ke tabel customer =====
    $queryCustomer = "INSERT INTO customer (customer_id, name, phone_number, address, city)
                      VALUES ('$customerID', '$nama', '$telepon', '$alamat', '-')";

    if (!$conn->query($queryCustomer)) {
        die("Error Insert Customer: " . $conn->error);
    }

    // ===== 3. Generate Queue Number =====
    $prefix = "Q";
    $result2 = $conn->query("SELECT queue_number FROM queue ORDER BY queue_id DESC LIMIT 1");

    if ($result2->num_rows > 0) {
        $lastQueue = $result2->fetch_assoc()['queue_number'];
        $numQ = (int) substr($lastQueue, 2) + 1;
        $queueNumber = $prefix . "-" . str_pad($numQ, 2, "0", STR_PAD_LEFT);
    } else {
        $queueNumber = $prefix . "-01";
    }

    // ===== 4. Insert ke tabel queue =====
    $queryQueue = "INSERT INTO queue (queue_number, customer_id, nama, telepon, alamat, keluhan, id_menu, priority, status, tanggal)
                   VALUES ('$queueNumber', '$customerID', '$nama', '$telepon', '$alamat', '$keluhan', '$id_menu', '$priority', 'Menunggu', CURDATE())";

    if (!$conn->query($queryQueue)) {
        die("Error Insert Queue: " . $conn->error);
    }

    header("Location: tiket_antrian.php?antrian=" . $queueNumber);
    exit();
}
?>
