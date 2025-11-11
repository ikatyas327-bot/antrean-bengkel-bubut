<?php
// customer/track.php
header('Content-Type: application/json');
$mysqli = require '../koneksi.php';

$phone = trim($_GET['phone'] ?? '');
if (!$phone) { echo json_encode(['found'=>false]); exit; }

// ambil antrian terakhir customer hari ini (status apapun) berdasarkan telepon
$stmt = $mysqli->prepare("SELECT q.id, q.queue_number, q.status, q.created_at, q.id_menu, m.name AS service_name
                          FROM queue q LEFT JOIN menu m ON q.id_menu = m.id_menu
                          WHERE q.telepon = ? AND DATE(q.created_at)=CURDATE()
                          ORDER BY q.id DESC LIMIT 1");
$stmt->bind_param("s", $phone);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();
if (!$row) { echo json_encode(['found'=>false]); exit; }

// hitung posisi: count how many menunggu earlier than this record for same service
$posStmt = $mysqli->prepare("SELECT COUNT(*) FROM queue WHERE id_menu = ? AND status='Menunggu' AND DATE(created_at)=CURDATE() AND created_at <= ?");
$posStmt->bind_param("is", $row['id_menu'], $row['created_at']);
$posStmt->execute();
$posStmt->bind_result($pos);
$posStmt->fetch();
$posStmt->close();

// estimate ETA simple: position * average estimate_days for service
$estStmt = $mysqli->prepare("SELECT COALESCE(estimate_days,0) FROM menu WHERE id_menu = ?");
$estStmt->bind_param("i",$row['id_menu']);
$estStmt->execute();
$estStmt->bind_result($estimate_days);
$estStmt->fetch();
$estStmt->close();

$eta = null;
if ($estimate_days && $pos > 0) {
    // calculate ETA as created_at + (pos * estimate_days) days
    $ts = strtotime($row['created_at']);
    $sec = $pos * intval($estimate_days) * 24 * 3600;
    $eta = date('d M Y H:i', $ts + $sec);
}

echo json_encode([
  'found'=>true,
  'id'=>$row['id'],
  'queue_number'=>$row['queue_number'],
  'service_name'=>$row['service_name'],
  'status'=>$row['status'],
  'position'=>intval($pos),
  'eta'=>$eta
]);
