<?php
// admin/dashboard.php
// DEVELOPMENT: tampilkan error supaya gampang debugging (hapus di produksi)
ini_set('display_errors',1);
error_reporting(E_ALL);

$mysqli = require __DIR__ . '/../koneksi.php'; // sesuaikan path kalau koneksi di tempat lain
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard Admin - Antrian</title>

  <!-- DataTables + jQuery CDN (offline: download dan letakkan di project) -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <style>
    body{font-family: Arial, Helvetica, sans-serif; padding:20px;}
    .btn {padding:8px 12px; border-radius:6px; border:none; cursor:pointer;}
    .btn-primary{background:#1d4ed8;color:#fff;}
    .btn-warning{background:#f59e0b;color:#fff;}
    .btn-danger{background:#ef4444;color:#fff;}
  </style>
</head>
<body>
  <h1>Dashboard Antrian (Admin)</h1>

  <table id="queues" class="display" style="width:100%">
    <thead>
      <tr>
        <th>#</th>
        <th>Queue No</th>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Layanan</th>
        <th>Prioritas</th>
        <th>Status</th>
        <th>Waktu</th>
        <th>Aksi</th>
      </tr>
    </thead>
  </table>

<script>
$(document).ready(function(){
  const table = $('#queues').DataTable({
    ajax: {
      url: 'queues_data.php', // endpoint yang akan kita buat di admin/
      type: 'POST',
      dataSrc: 'data'
    },
    columns: [
      { data: 'queue_id' },
      { data: 'queue_number' },
      { data: 'nama' },
      { data: 'telepon' },
      { data: 'service_name' },
      { data: 'priority' },
      { data: 'status' },
      { data: 'created_at' },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: function(row){
          // tombol ubah status dropdown + hapus
          return `
            <button class="btn btn-warning btn-change" data-id="${row.queue_id}" data-status="Diproses">Mulai</button>
            <button class="btn btn-primary btn-change" data-id="${row.queue_id}" data-status="Selesai">Selesai</button>
            <button class="btn btn-danger btn-delete" data-id="${row.queue_id}">Hapus</button>
          `;
        }
      }
    ],
    order: [[0,'asc']],
    pageLength: 15
  });

  // klik ubah status
  $('#queues').on('click', '.btn-change', function(){
    const id = $(this).data('id');
    const status = $(this).data('status');
    if(!confirm(`Ubah status #${id} → ${status}?`)) return;
    $.post('api_change_status.php', { queue_id:id, status:status }, function(resp){
      if(resp.success){
        alert('Status diupdate');
        table.ajax.reload(null,false);
      } else {
        alert('Gagal: ' + (resp.error || 'unknown'));
      }
    }, 'json').fail(function(){ alert('Request error'); });
  });

  // hapus
  $('#queues').on('click', '.btn-delete', function(){
    const id = $(this).data('id');
    if(!confirm(`Hapus antrian #${id} ?`)) return;
    $.post('api_delete.php', { queue_id:id }, function(resp){
      if(resp.success){
        alert('Data dihapus');
        table.ajax.reload(null,false);
      } else {
        alert('Gagal hapus: ' + (resp.error||'unknown'));
      }
    }, 'json').fail(function(){ alert('Request error'); });
  });
});
</script>
</body>
</html>
