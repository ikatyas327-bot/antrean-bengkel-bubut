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
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--color-bg-light);
            color: var(--color-text);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* 1. SIDEBAR (NAVIGASI KIRI) */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--color-bg-sidebar);
            color: #ffffff;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
            z-index: 100;
        }

        .sidebar-header {
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 15px;
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--color-secondary);
        }
        
        .sidebar-header p {
            font-size: 0.8rem; 
            color: rgba(255, 255, 255, 0.5);
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 14px 25px;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 5px 15px;
            border-radius: 8px;
            cursor: pointer; /* Penting untuk interaksi JS */
        }

        .sidebar-menu a:hover {
            background-color: rgba(0, 163, 137, 0.1);
            color: var(--color-secondary);
        }

        .sidebar-menu a.active {
            background: var(--color-secondary);
            color: #fff;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(0, 163, 137, 0.4);
        }
        
        .sidebar-footer {
            margin-top: auto;
            padding: 20px 25px;
        }
        
        .sidebar-footer a {
            color: #EF4444; 
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border: 1px solid #EF4444;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.2s;
            justify-content: center;
        }
        .sidebar-footer a:hover {
            background-color: #EF4444;
            color: #fff;
        }


        /* 2. MAIN CONTENT AREA */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        /* 3. HEADER ADMIN (ATAS) */
        .admin-header {
            background-color: #ffffff;
            padding: 15px 30px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .admin-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--color-primary);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: var(--color-accent);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.5);
            cursor: pointer;
        }

        /* 4. DASHBOARD CONTENT & SECTION STYLES */
        .dashboard-content {
            padding: 35px;
            flex-grow: 1;
        }

        /* Menyembunyikan semua section konten secara default */
        .content-section {
            display: none;
            animation: fadeIn 0.5s;
        }
        /* Menampilkan section yang sedang aktif */
        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Statistik Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            border: 1px solid #E5E7EB;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        
        .stat-card:nth-child(1) .card-icon { background: linear-gradient(45deg, var(--color-secondary), #00C8A7); color: white; }
        .stat-card:nth-child(2) .card-icon { background: linear-gradient(45deg, var(--color-accent), #FFB74D); color: white; }
        .stat-card:nth-child(3) .card-icon { background: linear-gradient(45deg, var(--color-primary), #3B82F6); color: white; }
        .stat-card:nth-child(4) .card-icon { background: linear-gradient(45deg, #EF4444, #F87171); color: white; }


        .stat-card .label {
            font-size: 0.95rem;
            color: #6B7280;
            font-weight: 500;
        }

        .stat-card .value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--color-text);
            margin: 5px 0 8px 0;
        }

        .trend-up { color: #059669; font-size: 0.85rem; font-weight: 600;}
        .trend-attention { color: #D97706; font-size: 0.85rem; font-weight: 600; }
        .trend-neutral { color: var(--color-primary); font-size: 0.85rem; font-weight: 600; }

        /* Tabel dan Laporan (Umum) */
        .report-section {
            background-color: #ffffff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            margin-bottom: 30px;
            border: 1px solid #E5E7EB;
        }

        .report-section h3 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--color-text);
        }

        table {
            width: 100%;
            border-collapse: separate; 
            border-spacing: 0;
            font-size: 0.9rem;
        }

        th, td {
            text-align: left;
            padding: 15px 20px;
            border-bottom: 1px solid #F3F4F6;
        }

        th {
            background-color: #F8F9FB; 
            color: var(--color-primary);
            font-weight: 700;
        }
        
        tbody tr:hover {
            background-color: #FAFBFD;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-badge.pending { background-color: #FEF3C7; color: #D97706; }
        .status-badge.in-progress { background-color: #DBEAFE; color: #2563EB; }
        .status-badge.completed { background-color: #D1FAE5; color: #059669; }
        .status-badge.cancelled { background-color: #FEE2E2; color: #EF4444; }


        /* Tombol Aksi */
        .btn {
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: var(--color-secondary);
            color: white;
        }
        .btn-primary:hover { background-color: #00877c; }

        .btn-secondary {
            background-color: #E5E7EB;
            color: var(--color-text);
            border: 1px solid #D1D5DB;
        }
        .btn-secondary:hover { background-color: #D1D5DB; }

        .btn-action {
            padding: 5px 10px;
            font-size: 0.85rem;
            margin-left: 5px;
        }
        
        .header-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* IKON SIMULASI */
        .fa { padding-right: 10px; }
        .fa-tachometer-alt::before { content: '🏠'; }
        .fa-cogs::before { content: '🔧'; }
        .fa-users::before { content: '👨‍👩‍👧‍👦'; }
        .fa-calendar-check::before { content: '🗓️'; }
        .fa-wrench::before { content: '⚙️'; }
        .fa-file-invoice-dollar::before { content: '💲'; }
        .fa-sign-out-alt::before { content: '➡️'; }
        
        /* --- KODE BARU UNTUK CRUD MODAL --- */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 200; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6); 
            padding-top: 50px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 30px;
            border-radius: 12px;
            width: 90%; 
            max-width: 500px; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: zoomIn 0.3s;
        }
        
        .modal-content h3 {
            color: var(--color-primary);
            margin-bottom: 20px;
            font-size: 1.5rem;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 10px;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: var(--color-accent);
            text-decoration: none;
        }

        .form-group-modal {
            margin-bottom: 15px;
        }

        .form-group-modal label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--color-text);
        }

        .form-group-modal input[type="text"],
        .form-group-modal input[type="number"],
        .form-group-modal input[type="email"],
        .form-group-modal textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        
        @keyframes zoomIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        /* --- AKHIR KODE BARU UNTUK CRUD MODAL --- */
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>E-SPEED ADMIN</h2>
            <p>Bengkel Dashboard</p>
        </div>

        <nav class="sidebar-menu">
            <a data-target="dashboard" class="menu-item active"><span class="fa fa-tachometer-alt"></span> Dashboard Utama</a>
            <a data-target="layanan" class="menu-item"><span class="fa fa-cogs"></span> Manajemen Layanan</a>
            <a data-target="pelanggan" class="menu-item"><span class="fa fa-users"></span> Manajemen Pelanggan</a>
            <a data-target="antrian" class="menu-item"><span class="fa fa-calendar-check"></span> Pesanan Antrian</a>
            <a data-target="laporan" class="menu-item"><span class="fa fa-wrench"></span> Laporan Servis</a>
            <a data-target="keuangan" class="menu-item"><span class="fa fa-file-invoice-dollar"></span> Transaksi & Keuangan</a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="login.html"><span class="fa fa-sign-out-alt"></span> Logout</a>
        </div>
    </div>

    <div class="main-content">

        <header class="admin-header">
            <h1 id="pageTitle">Dashboard Utama</h1>
            <div class="user-info">
                <p>Halo, Admin E-SPEED</p>
                <div class="avatar">A</div>
            </div>
        </header>

        <section class="dashboard-content content-section active" id="dashboard">
            <h2>Ringkasan Kinerja Bengkel</h2>
            <div class="stats-grid">
                
                <div class="stat-card">
                    <div class="card-icon">🗓️</div>
                    <p class="label">Antrian Hari Ini</p>
                    <p class="value">12</p>
                    <p class="trend trend-up">+2 Antrian Baru</p>
                </div>

                <div class="stat-card">
                    <div class="card-icon">🔔</div>
                    <p class="label">Pesanan Pending</p>
                    <p class="value">5</p>
                    <p class="trend trend-attention">Perhatian: Segera Diproses!</p>
                </div>

                <div class="stat-card">
                    <div class="card-icon">✅</div>
                    <p class="label">Servis Selesai (Bulan Ini)</p>
                    <p class="value">85</p>
                    <p class="trend trend-neutral">Target: 100 Servis</p>
                </div>

                <div class="stat-card">
                    <div class="card-icon">💲</div>
                    <p class="label">Total Pendapatan (Bulan Ini)</p>
                    <p class="value">Rp 125 Jt</p>
                    <p class="trend trend-up">Kenaikan 15% dari Bulan Lalu</p>
                </div>
            </div>

            <div class="report-section">
                <h3>Antrian Servis Terbaru</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID Antrian</th>
                            <th>Nama Pelanggan</th>
                            <th>Jenis Perbaikan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr> <td>#EKB0124</td> <td>Budi Santoso</td> <td>Bubut Poros</td> <td><span class="status-badge in-progress">Dalam Proses</span></td> <td><button class="btn btn-secondary btn-action">Lihat Detail</button></td> </tr>
                        <tr> <td>#EKB0123</td> <td>Siti Aisyah</td> <td>Bor Roda Gigi</td> <td><span class="status-badge completed">Selesai</span></td> <td><button class="btn btn-secondary btn-action">Cetak Invoice</button></td> </tr>
                        <tr> <td>#EKB0122</td> <td>Joko Wibowo</td> <td>Tapping Ulir Dalam</td> <td><span class="status-badge pending">Pending</span></td> <td><button class="btn btn-primary btn-action">Konfirmasi</button></td> </tr>
                    </tbody>
                </table>
            </div>
            
        </section>
        
        <section class="dashboard-content content-section" id="layanan">
            <div class="header-controls">
                <h2>Manajemen Layanan</h2>
                <button class="btn btn-primary" onclick="openModal('layananModal', 'Tambah Layanan Baru')"><span style="font-size: 1.2rem;">➕</span> Tambah Layanan Baru</button>
            </div>
            
            <div class="report-section">
                <h3>Daftar Layanan Tersedia (C-R-U-D)</h3>
                <table id="tabelLayanan">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Layanan</th>
                            <th>Harga Dasar (Rp)</th>
                            <th>Waktu Pengerjaan (Jam)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="L001" data-nama="Bubut Poros" data-harga="150000" data-waktu="3"> 
                            <td>L001</td> 
                            <td>Bubut Poros</td> 
                            <td>150.000</td> 
                            <td>3</td> 
                            <td>
                                <button class="btn btn-secondary btn-action edit-layanan" data-id="L001">✍️ Edit</button> 
                                <button class="btn btn-secondary btn-action delete-layanan" style="background-color: #FEE2E2; color: #EF4444;" data-id="L001" data-nama="Bubut Poros">🗑️ Hapus</button>
                            </td> 
                        </tr>
                        <tr data-id="L002" data-nama="Frais Permukaan" data-harga="200000" data-waktu="4"> 
                            <td>L002</td> 
                            <td>Frais Permukaan</td> 
                            <td>200.000</td> 
                            <td>4</td> 
                            <td>
                                <button class="btn btn-secondary btn-action edit-layanan" data-id="L002">✍️ Edit</button> 
                                <button class="btn btn-secondary btn-action delete-layanan" style="background-color: #FEE2E2; color: #EF4444;" data-id="L002" data-nama="Frais Permukaan">🗑️ Hapus</button>
                            </td> 
                        </tr>
                        <tr data-id="L003" data-nama="Tapping Ulir" data-harga="80000" data-waktu="2"> 
                            <td>L003</td> 
                            <td>Tapping Ulir</td> 
                            <td>80.000</td> 
                            <td>2</td> 
                            <td>
                                <button class="btn btn-secondary btn-action edit-layanan" data-id="L003">✍️ Edit</button> 
                                <button class="btn btn-secondary btn-action delete-layanan" style="background-color: #FEE2E2; color: #EF4444;" data-id="L003" data-nama="Tapping Ulir">🗑️ Hapus</button>
                            </td> 
                        </tr>
                    </tbody>
                </table>
                <p style="margin-top: 20px; font-size: 0.85rem; color: #6B7280;">*Harga bersifat dasar, dapat disesuaikan berdasarkan kompleksitas material. Data CRUD disimulasikan di halaman ini.</p>
            </div>
        </section>

        <section class="dashboard-content content-section" id="antrian">
            <div class="header-controls">
                <h2>Pesanan Antrian</h2>
                <button class="btn btn-primary">Lihat Kalender Booking 📅</button>
            </div>
            
            <div class="report-section">
                <h3>Semua Daftar Pesanan Masuk</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Layanan (Estimasi)</th>
                            <th>Tgl. Booking</th>
                            <th>Status</th>
                            <th>Keluhan Singkat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr> <td>P005</td> <td>Roni Wijaya</td> <td>Bubut Poros</td> <td>09/11/2025</td> <td><span class="status-badge pending">Pending</span></td> <td>Poros bengkok, perlu diperhalus.</td> <td><button class="btn btn-primary btn-action">Proses</button></td></tr>
                        <tr> <td>P004</td> <td>Maria Utami</td> <td>Frais Permukaan</td> <td>07/11/2025</td> <td><span class="status-badge in-progress">Dalam Proses</span></td> <td>Mengikis 0.5mm dari permukaan.</td> <td><button class="btn btn-secondary btn-action">Selesaikan</button></td></tr>
                        <tr> <td>P003</td> <td>Andre Setya</td> <td>Tapping Ulir</td> <td>06/11/2025</td> <td><span class="status-badge completed">Selesai</span></td> <td>Pembuatan ulir baru M10.</td> <td><button class="btn btn-secondary btn-action">Arsipkan</button></td></tr>
                        <tr> <td>P002</td> <td>Fina Dewi</td> <td>Bubut Poros</td> <td>05/11/2025</td> <td><span class="status-badge cancelled">Dibatalkan</span></td> <td>Gagal menghubungi pelanggan.</td> <td><button class="btn btn-secondary btn-action">Hapus</button></td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="dashboard-content content-section" id="pelanggan">
            <div class="header-controls">
                <h2>Manajemen Pelanggan</h2>
                <button class="btn btn-primary" onclick="openModal('pelangganModal', 'Tambah Data Pelanggan Baru')"><span style="font-size: 1.2rem;">➕</span> Tambah Pelanggan</button>
            </div>
            
            <div class="report-section">
                <h3>Daftar Pelanggan Terdaftar (C-R-U-D)</h3>
                <table id="tabelPelanggan">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Email/Telepon</th>
                            <th>Total Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="C001" data-nama="Budi Santoso" data-email="budi.s@mail.com" data-telepon="0811223344"> 
                            <td>C001</td> 
                            <td>Budi Santoso</td> 
                            <td>budi.s@mail.com</td>
                            <td>Rp 1.250.000</td> 
                            <td>
                                <button class="btn btn-secondary btn-action edit-pelanggan" data-id="C001">✍️ Edit</button> 
                                <button class="btn btn-secondary btn-action">👁️ Detail Histori</button>
                                <button class="btn btn-secondary btn-action delete-pelanggan" style="background-color: #FEE2E2; color: #EF4444;" data-id="C001" data-nama="Budi Santoso">🗑️ Hapus</button>
                            </td> 
                        </tr>
                        <tr data-id="C002" data-nama="Siti Aisyah" data-email="siti@mail.com" data-telepon="08123456789"> 
                            <td>C002</td> 
                            <td>Siti Aisyah</td> 
                            <td>08123456789</td>
                            <td>Rp 500.000</td> 
                            <td>
                                <button class="btn btn-secondary btn-action edit-pelanggan" data-id="C002">✍️ Edit</button> 
                                <button class="btn btn-secondary btn-action">👁️ Detail Histori</button>
                                <button class="btn btn-secondary btn-action delete-pelanggan" style="background-color: #FEE2E2; color: #EF4444;" data-id="C002" data-nama="Siti Aisyah">🗑️ Hapus</button>
                            </td> 
                        </tr>
                        <tr data-id="C003" data-nama="Joko Wibowo" data-email="joko.w@yahoo.com" data-telepon="08987654321"> 
                            <td>C003</td> 
                            <td>Joko Wibowo</td> 
                            <td>joko.w@yahoo.com</td>
                            <td>Rp 80.000</td> 
                            <td>
                                <button class="btn btn-secondary btn-action edit-pelanggan" data-id="C003">✍️ Edit</button> 
                                <button class="btn btn-secondary btn-action">👁️ Detail Histori</button>
                                <button class="btn btn-secondary btn-action delete-pelanggan" style="background-color: #FEE2E2; color: #EF4444;" data-id="C003" data-nama="Joko Wibowo">🗑️ Hapus</button>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="dashboard-content content-section" id="laporan">
            <h2>Laporan Servis</h2>
            <div class="report-section" style="min-height: 250px;">
                <p style="font-style: italic; color: #6B7280;">Halaman ini untuk menghasilkan laporan periodik (harian, bulanan, tahunan) mengenai total servis yang diselesaikan, servis berdasarkan jenis layanan, dan performa teknisi.</p>
            </div>
        </section>

        <section class="dashboard-content content-section" id="keuangan">
            <h2>Transaksi & Keuangan</h2>
            <div class="report-section" style="min-height: 250px;">
                <p style="font-style: italic; color: #6B7280;">Halaman ini akan berfokus pada pencatatan dan rekapitulasi transaksi (pemasukan dan pengeluaran) serta ringkasan profit bulanan/tahunan.</p>
            </div>
        </section>

    </div>

    <div id="layananModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" data-modal-id="layananModal">&times;</span>
            <h3 id="layananModalTitle">Tambah Layanan Baru</h3>
            <form id="formLayanan">
                <input type="hidden" id="layananId"> <div class="form-group-modal">
                    <label for="layananNama">Nama Layanan</label>
                    <input type="text" id="layananNama" required placeholder="Contoh: Bubut Poros, Frais Permukaan">
                </div>
                <div class="form-group-modal">
                    <label for="layananHarga">Harga Dasar (Rp)</label>
                    <input type="number" id="layananHarga" required placeholder="Cth: 150000" min="0">
                </div>
                <div class="form-group-modal">
                    <label for="layananWaktu">Waktu Pengerjaan (Jam)</label>
                    <input type="number" id="layananWaktu" required placeholder="Cth: 3" min="1">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Layanan</button>
            </form>
        </div>
    </div>
    
    <div id="pelangganModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" data-modal-id="pelangganModal">&times;</span>
            <h3 id="pelangganModalTitle">Tambah Data Pelanggan Baru</h3>
            <form id="formPelanggan">
                <input type="hidden" id="pelangganId"> <div class="form-group-modal">
                    <label for="pelangganNama">Nama Lengkap</label>
                    <input type="text" id="pelangganNama" required placeholder="Nama Lengkap Pelanggan">
                </div>
                <div class="form-group-modal">
                    <label for="pelangganEmail">Email</label>
                    <input type="email" id="pelangganEmail" placeholder="email@contoh.com">
                </div>
                <div class="form-group-modal">
                    <label for="pelangganTelepon">Nomor Telepon</label>
                    <input type="text" id="pelangganTelepon" required placeholder="Cth: 08123456789">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Pelanggan</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuItems = document.querySelectorAll('.menu-item');
            const contentSections = document.querySelectorAll('.content-section');
            const pageTitle = document.getElementById('pageTitle');
            
            // Logika Navigasi (TIDAK BERUBAH)
            function showContent(targetId, title) {
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });
                menuItems.forEach(item => {
                    item.classList.remove('active');
                });

                const activeSection = document.getElementById(targetId);
                if (activeSection) {
                    activeSection.classList.add('active');
                }

                const activeMenu = document.querySelector(`.menu-item[data-target="${targetId}"]`);
                if (activeMenu) {
                    activeMenu.classList.add('active');
                }

                pageTitle.textContent = title;
            }

            menuItems.forEach(item => {
                item.addEventListener('click', (event) => {
                    const targetId = event.currentTarget.getAttribute('data-target');
                    const title = event.currentTarget.textContent.trim();
                    showContent(targetId, title);
                });
            });

            // --- LOGIKA MODAL DAN CRUD BARU ---

            // FUNGSI UMUM UNTUK MEMBUKA MODAL
            window.openModal = function(modalId, title) {
                const modal = document.getElementById(modalId);
                const titleElement = document.getElementById(modalId + 'Title');
                
                if (titleElement) {
                    titleElement.textContent = title;
                }
                
                // Reset form saat membuka modal baru (tambah data)
                if (title.includes('Tambah')) {
                    const formId = modalId === 'layananModal' ? 'formLayanan' : 'formPelanggan';
                    document.getElementById(formId).reset();
                    document.getElementById(formId.replace('form', '').toLowerCase() + 'Id').value = ''; // Kosongkan ID hidden
                }
                
                modal.style.display = "block";
            }

            // TUTUP MODAL
            document.querySelectorAll('.close-btn').forEach(span => {
                span.onclick = function() {
                    const modalId = this.getAttribute('data-modal-id');
                    document.getElementById(modalId).style.display = "none";
                }
            });

            // TUTUP MODAL JIKA KLIK DI LUAR
            window.onclick = function(event) {
                if (event.target.classList.contains('modal')) {
                    event.target.style.display = "none";
                }
            }
            
            // --- CRUD MANAJEMEN LAYANAN ---

            // FUNGSI (C/U) - SIMULASI FORM SUBMIT LAYANAN
            document.getElementById('formLayanan').addEventListener('submit', function(event) {
                event.preventDefault();

                const id = document.getElementById('layananId').value;
                const nama = document.getElementById('layananNama').value;
                const harga = document.getElementById('layananHarga').value;
                const waktu = document.getElementById('layananWaktu').value;
                const action = id ? 'diperbarui' : 'ditambahkan';

                alert(`Layanan "${nama}" berhasil ${action} (Simulasi CRUD).`);
                document.getElementById('layananModal').style.display = "none";
                
                // Dalam aplikasi nyata, di sini Anda akan me-reload tabel dari database.
                // Karena ini simulasi, kita hanya menampilkan notifikasi.
                console.log(`Layanan Data: ID=${id}, Nama=${nama}, Harga=${harga}, Waktu=${waktu}`);
            });
            
            // FUNGSI (U) - SIMULASI EDIT LAYANAN
            document.querySelectorAll('.edit-layanan').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    
                    if (row) {
                        const nama = row.getAttribute('data-nama');
                        const harga = row.getAttribute('data-harga');
                        const waktu = row.getAttribute('data-waktu');

                        // Isi form modal dengan data yang ada
                        document.getElementById('layananId').value = id;
                        document.getElementById('layananNama').value = nama;
                        document.getElementById('layananHarga').value = harga;
                        document.getElementById('layananWaktu').value = waktu;

                        openModal('layananModal', `Edit Layanan: ${nama}`);
                    }
                });
            });

            // FUNGSI (D) - SIMULASI DELETE LAYANAN
            document.querySelectorAll('.delete-layanan').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    if (confirm(`Apakah Anda yakin ingin menghapus layanan "${nama}" (${id})?`)) {
                        alert(`Layanan "${nama}" berhasil dihapus (Simulasi CRUD).`);
                        // Dalam aplikasi nyata: Hapus baris dari DOM atau reload tabel.
                        // document.querySelector(`tr[data-id="${id}"]`).remove();
                    }
                });
            });


            // --- CRUD MANAJEMEN PELANGGAN ---

            // FUNGSI (C/U) - SIMULASI FORM SUBMIT PELANGGAN
            document.getElementById('formPelanggan').addEventListener('submit', function(event) {
                event.preventDefault();

                const id = document.getElementById('pelangganId').value;
                const nama = document.getElementById('pelangganNama').value;
                const telepon = document.getElementById('pelangganTelepon').value;
                const action = id ? 'diperbarui' : 'ditambahkan';

                alert(`Data pelanggan "${nama}" berhasil ${action} (Simulasi CRUD).`);
                document.getElementById('pelangganModal').style.display = "none";
                
                console.log(`Pelanggan Data: ID=${id}, Nama=${nama}, Telepon=${telepon}`);
            });
            
            // FUNGSI (U) - SIMULASI EDIT PELANGGAN
            document.querySelectorAll('.edit-pelanggan').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    
                    if (row) {
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