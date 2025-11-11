<?php
// admin.php - Halaman Admin dengan tampilan data Antrian
session_start();

// Cek apakah admin sudah login (Pastikan Anda sudah mengimplementasikan login di login.php)
if (!isset($_SESSION['admin_id'])) {
    // Sesuaikan path ke login.php jika file ini berada di folder yang berbeda
    header("Location: login.php");
    exit;
}

// Koneksi ke database
// Catatan: Saya menggunakan 'require '../koneksi.php';' mengikuti pola file Anda yang lain.
// Jika koneksi.php berada di folder yang sama, ubah menjadi 'require "koneksi.php";'
require '../koneksi.php'; 

// Query untuk mengambil semua data antrian pelanggan
// Menggunakan JOIN untuk mendapatkan nama layanan dari tabel 'menu'
$sql = "SELECT 
            q.id, q.queue_number, q.nama, q.telepon, q.alamat, q.keluhan, 
            q.status, q.created_at, m.name AS service_name, q.priority
        FROM 
            queue q
        LEFT JOIN 
            menu m ON q.id_menu = m.id_menu
        ORDER BY 
            q.created_at DESC"; 

$result = $conn->query($sql);

$queue_data = [];
if ($result) {
    $queue_data = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Penanganan error database
    $error_message = "Error saat mengambil data antrian: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-SPEED Bengkel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* CSS DARI RESPON SEBELUMNYA (MODERN V2.0) */

        :root {
            --color-primary: #0C4A6E; /* Navy/Biru Tua */
            --color-secondary: #00A389; /* Tosca Cerah/Hijau Kehutanan */
            --color-accent: #F97316; /* Oranye Terang untuk Aksi */
            --color-bg-sidebar: #1F2937; /* Background Sidebar Gelap (Dark Accent) */
            --color-bg-light: #F4F6F9; /* Background Konten Sangat Cerah */
            --color-text: #1F2937;
            --sidebar-width: 260px;
            --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--color-text);
            line-height: 1.6;
            background-color: var(--color-bg-light);
        }

        /* Struktur Layout */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--color-bg-sidebar);
            color: #E5E7EB; /* Text abu muda */
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
        }

        .sidebar-header {
            padding: 16px 8px;
            text-align: center;
            margin-bottom: 24px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            margin-bottom: 8px;
            border-radius: 8px;
            color: #D1D5DB;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #374151; /* hover/active background */
            color: white;
        }
        
        .nav-link svg {
            margin-right: 12px;
        }

        .logout-link {
            margin-top: auto;
            border-top: 1px solid #374151;
            padding-top: 16px;
        }

        /* Konten Utama */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
        }

        .header {
            background-color: white;
            padding: 16px 32px;
            box-shadow: var(--shadow-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .content {
            padding: 32px;
        }

        /* Card (kotak konten) */
        .card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            border: 1px solid #E5E7EB;
        }
        
        .card-header {
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #E5E7EB;
            background-color: #F9FAFB;
        }

        .card-title {
            font-size: 1.25rem; /* text-xl */
            font-weight: 600;
            color: var(--color-text);
        }

        .card-body {
            padding: 24px;
        }

        /* Tabel Styling */
        .table-auto {
            border-collapse: collapse;
        }

        .table-auto thead th {
            font-size: 0.75rem; /* text-xs */
            font-weight: 600;
            letter-spacing: 0.05em;
            color: #6B7280; /* text-gray-500 */
            text-transform: uppercase;
            border-bottom: 2px solid #E5E7EB;
        }

        .table-auto tbody td {
            font-size: 0.875rem; /* text-sm */
            border-bottom: 1px solid #F3F4F6;
        }
        
        .table-auto tbody tr:last-child td {
            border-bottom: none;
        }

        /* Utility Classes (simulasi Tailwind) */
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .font-bold { font-weight: 700; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mt-10 { margin-top: 2.5rem; }
        .text-color-primary { color: var(--color-primary); }
        .p-6 { padding: 1.5rem; }
        .p-0 { padding: 0; }
        .w-full { width: 100%; }
        .text-sm { font-size: 0.875rem; }
        .text-gray-500 { color: #6B7280; }
        .bg-gray-50 { background-color: #F9FAFB; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .font-semibold { font-weight: 600; }
        .border-b { border-bottom-width: 1px; border-color: #E5E7EB; }
        .hover\:bg-gray-50:hover { background-color: #F9FAFB; }
        .text-center { text-align: center; }
        .btn-primary { 
            background-color: var(--color-primary); color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; transition: background-color 0.2s; border: none; cursor: pointer;
        }
        .btn-primary:hover { background-color: #0A3A56; }
        .btn-secondary { 
            background-color: #E5E7EB; color: var(--color-text); padding: 8px 16px; border-radius: 6px; font-weight: 500; transition: background-color 0.2s; border: none; cursor: pointer;
            display: inline-flex; align-items: center;
        }
        .btn-secondary:hover { background-color: #D1D5DB; }
        .btn-icon { background: none; border: none; cursor: pointer; padding: 4px; border-radius: 4px; }
        .hover\:text-color-accent:hover { color: var(--color-accent); }
        .shadow-light { box-shadow: var(--shadow-light); }
        
        /* Modal Styling (untuk simulasi CRUD/Detail Antrian) */
        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex; justify-content: center; align-items: center;
            z-index: 10000;
            visibility: hidden; opacity: 0;
            transition: visibility 0s, opacity 0.3s;
        }

        .modal-overlay.active {
            visibility: visible; opacity: 1;
        }

        .modal-content {
            background: white; border-radius: 12px; width: 90%; max-width: 600px;
            max-height: 90vh; overflow-y: auto;
            transform: translateY(-50px);
            transition: transform 0.3s;
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0);
        }
        
        .modal-header {
            padding: 16px 24px; border-bottom: 1px solid #E5E7EB; display: flex; justify-content: space-between; align-items: center;
        }

        .modal-body {
            padding: 24px;
        }
        
        /* Tambahan CSS untuk badge status Antrian */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 9999px; /* rounded-full */
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-menunggu {
            background-color: #FEF3C7; /* yellow-100 */
            color: #D97706; /* yellow-700 */
        }
        .status-diproses {
            background-color: #DBEAFE; /* blue-100 */
            color: #2563EB; /* blue-700 */
        }
        .status-selesai {
            background-color: #D1FAE5; /* green-100 */
            color: #059669; /* green-700 */
        }
        .status-dibatalkan {
            background-color: #FEE2E2; /* red-100 */
            color: #EF4444; /* red-500 */
        }
        </style>
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 style="font-size:1.5rem; color: var(--color-secondary);">E-SPEED</h1>
                <p style="font-size:0.875rem; color: #9CA3AF;">Dashboard Admin</p>
            </div>
            
            <nav>
                <a href="#antrian" class="nav-link active">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V17a2 2 0 01-2 2z"></path></svg>
                    Daftar Antrian
                </a>
                <a href="#pelanggan" class="nav-link">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2m0 2a2 2 0 100-4 2 2 0 000 4zM12 18.5A2.5 2.5 0 019.5 16h-1A4.5 4.5 0 0013 20.5v0zm-2-9a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Data Pelanggan
                </a>
                </nav>

            <a href="logout.php" class="nav-link logout-link">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </a>
        </aside>

        <div class="main-content">
            <header class="header">
                <div>Halo, **<?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?>**</div>
                </header>

            <main class="content">
                <h1 class="text-3xl font-bold mb-6 text-color-primary" id="antrian">Daftar Antrian Pelanggan</h1>
                
                <div class="card shadow-light mb-6">
                    <header class="card-header">
                        <h2 class="card-title">Antrian Masuk</h2>
                        <button onclick="window.location.reload()" class="btn-secondary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5m-1 5a9 9 0 01-13.9-6.3M20 4a9 9 0 01-13.9 6.3"></path></svg>
                            Refresh Data
                        </button>
                    </header>

                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-500 bg-gray-50 uppercase tracking-wider">
                                        <th class="py-3 px-4 font-semibold">No. Antri</th>
                                        <th class="py-3 px-4 font-semibold">Nama Pelanggan</th>
                                        <th class="py-3 px-4 font-semibold">Layanan</th>
                                        <th class="py-3 px-4 font-semibold">Telepon</th>
                                        <th class="py-3 px-4 font-semibold">Status</th>
                                        <th class="py-3 px-4 font-semibold">Waktu Masuk</th>
                                        <th class="py-3 px-4 font-semibold">Prioritas</th>
                                        <th class="py-3 px-4 font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($queue_data)): ?>
                                        <?php foreach ($queue_data as $row): ?>
                                            <tr class="border-b hover:bg-gray-50" data-id="<?= htmlspecialchars($row['id']) ?>">
                                                <td class="py-3 px-4 font-medium text-color-primary"><?= htmlspecialchars($row['queue_number']) ?></td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($row['nama']) ?></td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($row['service_name']) ?></td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($row['telepon']) ?></td>
                                                <td class="py-3 px-4">
                                                    <span class="status-badge status-<?= strtolower(htmlspecialchars($row['status'])) ?>">
                                                        <?= htmlspecialchars($row['status']) ?>
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4"><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($row['priority']) ?></td>
                                                <td class="py-3 px-4">
                                                    <button class="btn-icon text-color-primary hover:text-color-accent view-detail-antrian" 
                                                            data-id="<?= htmlspecialchars($row['id']) ?>" 
                                                            data-nama="<?= htmlspecialchars($row['nama']) ?>"
                                                            data-layanan="<?= htmlspecialchars($row['service_name']) ?>"
                                                            data-keluhan="<?= htmlspecialchars($row['keluhan']) ?>"
                                                            data-alamat="<?= htmlspecialchars($row['alamat']) ?>"
                                                            data-telepon="<?= htmlspecialchars($row['telepon']) ?>">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </button>
                                                    <button class="btn-icon text-color-secondary hover:text-color-accent process-antrian" 
                                                            data-id="<?= htmlspecialchars($row['id']) ?>" 
                                                            data-nama="<?= htmlspecialchars($row['nama']) ?>">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="py-6 px-4 text-center text-gray-500">
                                                <?php echo isset($error_message) ? $error_message : 'Belum ada data antrian yang masuk.'; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <h1 class="text-3xl font-bold mb-6 text-color-primary mt-10" id="pelanggan">Data Pelanggan (Simulasi CRUD)</h1>

                <div class="card shadow-light mb-6">
                    <header class="card-header">
                        <h2 class="card-title">Daftar Pelanggan</h2>
                        <button class="btn-primary" onclick="openModal('pelangganModal', 'Tambah Pelanggan Baru')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah Pelanggan
                        </button>
                    </header>

                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-500 bg-gray-50 uppercase tracking-wider">
                                        <th class="py-3 px-4 font-semibold">ID</th>
                                        <th class="py-3 px-4 font-semibold">Nama</th>
                                        <th class="py-3 px-4 font-semibold">Email</th>
                                        <th class="py-3 px-4 font-semibold">Telepon</th>
                                        <th class="py-3 px-4 font-semibold">Total Transaksi</th>
                                        <th class="py-3 px-4 font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b hover:bg-gray-50" data-id="101" data-nama="Budi Santoso" data-email="budi@example.com" data-telepon="081211112222">
                                        <td class="py-3 px-4 text-gray-700">101</td>
                                        <td class="py-3 px-4 font-medium">Budi Santoso</td>
                                        <td class="py-3 px-4">budi@example.com</td>
                                        <td class="py-3 px-4">081211112222</td>
                                        <td class="py-3 px-4 text-right">Rp 450.000</td>
                                        <td class="py-3 px-4">
                                            <button class="btn-icon text-color-secondary hover:text-color-accent edit-pelanggan">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button class="btn-icon text-red-500 hover:text-red-700 delete-pelanggan" data-id="101" data-nama="Budi Santoso">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="border-b hover:bg-gray-50" data-id="102" data-nama="Siti Aisyah" data-email="siti@example.com" data-telepon="085733334444">
                                        <td class="py-3 px-4 text-gray-700">102</td>
                                        <td class="py-3 px-4 font-medium">Siti Aisyah</td>
                                        <td class="py-3 px-4">siti@example.com</td>
                                        <td class="py-3 px-4">085733334444</td>
                                        <td class="py-3 px-4 text-right">Rp 90.000</td>
                                        <td class="py-3 px-4">
                                            <button class="btn-icon text-color-secondary hover:text-color-accent edit-pelanggan">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button class="btn-icon text-red-500 hover:text-red-700 delete-pelanggan" data-id="102" data-nama="Siti Aisyah">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="detailAntrianModal" class="modal-overlay">
        <div class="modal-content">
            <header class="modal-header">
                <h3 class="text-xl font-semibold" id="detailAntrianTitle">Detail Antrian</h3>
                <button onclick="closeModal('detailAntrianModal')" class="btn-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </header>
            <div class="modal-body">
                <div style="display:grid; grid-template-columns: 1fr 2fr; gap:12px; margin-bottom: 16px;">
                    <div class="font-semibold text-gray-600">Nama Pelanggan</div> <div id="detailNama"></div>
                    <div class="font-semibold text-gray-600">Layanan</div> <div id="detailLayanan"></div>
                    <div class="font-semibold text-gray-600">Telepon</div> <div id="detailTelepon"></div>
                    <div class="font-semibold text-gray-600">Alamat</div> <div id="detailAlamat"></div>
                </div>
                <h4 class="font-semibold mt-4 mb-2 border-t pt-4">Keluhan/Catatan</h4>
                <div id="detailKeluhan" class="p-3 bg-gray-50 border rounded-md whitespace-pre-wrap"></div>
                
                <div class="mt-6 flex justify-end">
                    <button class="btn-secondary" onclick="closeModal('detailAntrianModal')">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div id="pelangganModal" class="modal-overlay">
        <div class="modal-content">
            <header class="modal-header">
                <h3 class="text-xl font-semibold" id="pelangganModalTitle">Tambah Pelanggan Baru</h3>
                <button onclick="closeModal('pelangganModal')" class="btn-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </header>
            <form id="pelangganForm" action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="pelangganId" name="id">
                    
                    <div style="margin-bottom: 16px;">
                        <label for="pelangganNama" style="display:block; margin-bottom: 4px; font-weight: 500;">Nama</label>
                        <input type="text" id="pelangganNama" name="nama" required 
                               style="width: 100%; padding: 8px; border: 1px solid #D1D5DB; border-radius: 6px;">
                    </div>
                    
                    <div style="margin-bottom: 16px;">
                        <label for="pelangganEmail" style="display:block; margin-bottom: 4px; font-weight: 500;">Email</label>
                        <input type="email" id="pelangganEmail" name="email" 
                               style="width: 100%; padding: 8px; border: 1px solid #D1D5DB; border-radius: 6px;">
                    </div>
                    
                    <div style="margin-bottom: 16px;">
                        <label for="pelangganTelepon" style="display:block; margin-bottom: 4px; font-weight: 500;">Telepon</label>
                        <input type="tel" id="pelangganTelepon" name="telepon" required
                               style="width: 100%; padding: 8px; border: 1px solid #D1D5DB; border-radius: 6px;">
                    </div>
                </div>
                
                <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #E5E7EB; display: flex; justify-content: flex-end; gap: 8px;">
                    <button type="button" class="btn-secondary" onclick="closeModal('pelangganModal')">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // --- FUNGSI MODAL UTAMA ---
        function openModal(id, title = null) {
            const modal = document.getElementById(id);
            if (title) {
                document.getElementById(id + 'Title').textContent = title;
            }
            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // cegah scroll body
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('active');
            document.body.style.overflow = ''; // izinkan scroll body
        }

        // Event listener untuk menutup modal saat klik di luar area konten
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeModal(overlay.id);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            
            // FUNGSI BARU (R) - LIHAT DETAIL ANTRIAN
            document.querySelectorAll('.view-detail-antrian').forEach(button => {
                button.addEventListener('click', function() {
                    const nama    = this.getAttribute('data-nama');
                    const layanan = this.getAttribute('data-layanan');
                    const telepon = this.getAttribute('data-telepon');
                    const alamat  = this.getAttribute('data-alamat');
                    const keluhan = this.getAttribute('data-keluhan');

                    // Isi modal detail
                    document.getElementById('detailNama').textContent    = nama;
                    document.getElementById('detailLayanan').textContent = layanan;
                    document.getElementById('detailTelepon').textContent = telepon;
                    document.getElementById('detailAlamat').textContent  = alamat || 'Tidak ada';
                    document.getElementById('detailKeluhan').textContent = keluhan || 'Tidak ada keluhan/catatan.';
                    
                    openModal('detailAntrianModal', `Detail Antrian: ${nama}`);
                });
            });

            // FUNGSI BARU (U) - SIMULASI PROSES ANTRIAN
            document.querySelectorAll('.process-antrian').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    if (confirm(`Apakah Anda yakin ingin mengubah status antrian ${nama} (${id}) menjadi 'Diproses'?`)) {
                        alert(`Status antrian ${nama} berhasil diubah ke 'Diproses' (Simulasi CRUD). Silakan refresh halaman.`);
                        // Dalam aplikasi nyata: Lakukan AJAX call ke file PHP untuk UPDATE status di database.
                        // window.location.reload(); 
                    }
                });
            });


            // --- FUNGSI LAMA (SIMULASI CRUD PELANGGAN) ---

            // FUNGSI (C/U) - SIMULASI FORM SUBMIT
            document.getElementById('pelangganForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('pelangganId').value;
                const nama = document.getElementById('pelangganNama').value;
                
                if (id) {
                    // Update
                    alert(`Data pelanggan ${nama} (ID: ${id}) berhasil diupdate (Simulasi CRUD).`);
                } else {
                    // Create
                    alert(`Data pelanggan baru ${nama} berhasil ditambahkan (Simulasi CRUD).`);
                }
                closeModal('pelangganModal');
                // Dalam aplikasi nyata: Lakukan AJAX call untuk INSERT/UPDATE data.
                // window.location.reload(); 
            });

            // FUNGSI (R) - SIMULASI EDIT PELANGGAN
            document.querySelectorAll('.edit-pelanggan').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    if (row) {
                        const id = row.getAttribute('data-id');
                        const nama = row.getAttribute('data-nama');
                        const email = row.getAttribute('data-email');
                        const telepon = row.getAttribute('data-telepon');

                        // Isi form modal dengan data yang ada
                        document.getElementById('pelangganId').value = id;
                        document.getElementById('pelangganNama').value = nama;
                        document.getElementById('pelangganEmail').value = email;
                        document.getElementById('pelangganTelepon').value = telepon;

                        openModal('pelangganModal', `Edit Pelanggan: ${nama}`);
                    }
                });
            });

            // FUNGSI (D) - SIMULASI DELETE PELANGGAN
            document.querySelectorAll('.delete-pelanggan').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    if (confirm(`Apakah Anda yakin ingin menghapus data pelanggan "${nama}" (${id})? Semua histori akan hilang.`)) {
                        alert(`Data pelanggan "${nama}" berhasil dihapus (Simulasi CRUD).`);
                        // Dalam aplikasi nyata: Hapus baris dari DOM atau reload tabel.
                        // document.querySelector(`tr[data-id="${id}"]`).remove();
                    }
                });
            });
        });
    </script>
</body>
</html>