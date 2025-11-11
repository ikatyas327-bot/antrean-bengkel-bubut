<?php
// index.php (customer) - E-SPEED MACHINING
// Pastikan file ini disimpan di: antrian_bengkel/customer/index.php
// Pastikan juga ada: koneksi.php di folder yang sama, style.css (sudah dibuat), simpan_antrian.php (sudah dibuat/diupdate)

// include koneksi
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>E-SPEED MACHINING - Ambil Antrian</title>

<!-- Link CSS (kamu sudah punya style.css) -->
<link rel="stylesheet" href="style.css">

<!-- kecil: tambahan CSS khusus modal wizard / bottom-sheet agar langsung rapi,
     tapi styling utama tetap di style.css -->
<style>
/* ------------ bottom sheet overlay (mobile style) ------------ */
.modal-overlay {
  position: fixed;
  left: 0; right: 0; bottom: 0;
  height: 0;
  visibility: hidden;
  z-index: 9999;
  transition: height .35s ease, visibility .35s ease;
}
.modal-overlay.open {
  height: 100%;
  visibility: visible;
  background: rgba(2,6,23,0.45);
}

/* bottom sheet container (sheet naik dari bawah) */
.bottom-sheet {
  position: absolute;
  left: 0; right: 0; bottom: 0;
  height: 75vh; /* H2 pilihanmu */
  transform: translateY(100%);
  transition: transform .35s ease;
  display:flex;
  justify-content:center;
  align-items:flex-end;
}
.modal-overlay.open .bottom-sheet {
  transform: translateY(0);
}

/* sheet card */
.sheet-card {
  width: 100%;
  max-width: 980px;          /* responsive */
  height: 75vh;
  background: linear-gradient(180deg, rgba(255,255,255,0.98), #ffffff);
  border-radius: 18px 18px 0 0;
  box-shadow: 0 -10px 40px rgba(2,6,23,0.2);
  padding: 18px 18px 30px 18px;
  display:flex;
  flex-direction:column;
  gap:12px;
  overflow:hidden;
  border-top: 3px solid #dbe7ff; /* chrome accent feel */
}

/* handle bar (small drag line) */
.sheet-handle {
  width: 56px;
  height: 6px;
  margin: 6px auto;
  border-radius: 10px;
  background: linear-gradient(90deg, rgba(27,60,115,0.6), rgba(26,115,232,0.6));
}

/* header bar (full blue bar - M1 choice earlier for header look inside sheet) */
.sheet-header {
  display:flex;
  align-items:center;
  justify-content:center;
  padding: 10px 8px;
  background: linear-gradient(90deg,#012A59,#0A3B7A); /* Navy gradient */
  color:#fff;
  border-radius:12px;
  font-weight:600;
}

/* wizard area: card slider container */
.wizard-container {
  flex:1;
  display:flex;
  align-items:center;
  justify-content:center;
  position:relative;
}

/* each step (card) */
.wizard-step {
  min-width:100%;
  transition: transform .35s ease, opacity .25s ease;
  padding: 12px;
  box-sizing:border-box;
  overflow:auto;
}

/* step controls */
.wizard-controls {
  display:flex;
  gap:8px;
  justify-content:space-between;
  align-items:center;
}

/* small stepper dots */
.stepper-dots { display:flex; gap:6px; align-items:center;}
.stepper-dots span {
  width:10px; height:10px; border-radius:50%;
  background:#d9e6ff; display:inline-block;
}
.stepper-dots span.active { background: var(--primary); box-shadow:0 0 6px rgba(26,115,232,0.3);}

/* form two-column grid */
.form-grid {
  display:grid;
  grid-template-columns: 1fr 1fr;
  gap:10px;
}

/* full width for small screens */
@media (max-width:820px) {
  .form-grid { grid-template-columns: 1fr; }
  .sheet-card { height: 85vh; }
}

/* small helpers */
.center { text-align:center; }
.small-muted { font-size:13px; color:#666; }
.card-compact { background: #f7fbff; padding:10px; border-radius:8px; border:1px solid #e3ecff; }
</style>
</head>
<body>

<!-- ================= HEADER (glass) ================= -->
<header class="glass-header" style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
  <div class="container" style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;">
    <div style="display:flex;align-items:center;gap:12px;">
      <!-- logo (located outside the customer folder) -->
      <img src="../image/umkmlogo.png" alt="Logo" style="width:56px;height:auto;">
      <div>
        <div style="font-weight:700;color:var(--primary-dark);font-size:18px;">E-SPEED MACHINING</div>
        <div style="font-size:12px;color:#6b7280;">Teknisi Ahli • Hasil Presisi • Tepat Waktu</div>
      </div>
    </div>

    <div style="display:flex;gap:12px;align-items:center;">
      <a href="#services" class="small-muted">Layanan</a>
      <a href="tiket_antrian.php" class="small-muted">Tiket</a>
      <button id="openWizardBtn" class="cta-btn">Ambil Antrian Sekarang</button>
    </div>
  </div>
</header>

<!-- ================= HERO (dark premium, BG2 with blur image overlay) ================= -->
<section class="hero" style="height: 55vh; background-image: url('../image/umkmlogo.png'); background-size:cover; background-position:center;">
  <div style="position: absolute; inset:0; background: linear-gradient(180deg, rgba(1,10,30,0.6), rgba(1,10,30,0.75)); mix-blend-mode:multiply;"></div>
  <div class="container" style="position:relative; z-index:3; display:flex;flex-direction:column; justify-content:center; height:55vh;">
    <div style="max-width:820px;">
      <h1 style="color:#fff;font-size:36px;margin-bottom:8px;">Presisi Tinggi Untuk Setiap Pengerjaan</h1>
      <p style="color:rgba(255,255,255,0.85); margin-bottom:18px; font-size:16px;">Solusi antrian dan service machining cepat — Ambil nomor antrean tanpa perlu datang dulu.</p>
      <div style="display:flex;gap:12px;">
        <button id="openWizardBtnHero" class="cta-btn" style="background:linear-gradient(90deg,#0A3B7A,#1B4F8E);">Ambil Antrian Sekarang</button>
        <a href="#services" class="btn-primary" style="background:transparent;border:1px solid rgba(255,255,255,0.12);color:#fff;">Daftar Layanan</a>
      </div>
    </div>
  </div>
</section>

<!-- ================= SERVICES (Card Modern L3-A) ================= -->
<section id="services" class="services">
  <div class="container">
    <h2 class="section-title">Layanan Kami</h2>

    <div class="service-grid">
      <?php
      // tarik data layanan dari tabel menu
      $menuQ = $conn->query("SELECT id_menu, name, description, price, estimated_work_time FROM menu ORDER BY id_menu ASC");
      while ($m = $menuQ->fetch_assoc()) {
        // price display: stored as number in DB
        $price_display = "Rp " . number_format($m['price'],0,',','.');
        // small icon selection (simple mapping based on name keywords)
        $icon = "🔧";
        if (stripos($m['name'],'las') !== false) $icon = "🛠️";
        if (stripos($m['name'],'bubut') !== false) $icon = "⚙️";
        if (stripos($m['name'],'frais') !== false) $icon = "🔩";
      ?>
        <div class="service-card">
          <div style="display:flex;align-items:center;gap:12px;justify-content:center;">
            <div style="font-size:28px;"><?= $icon; ?></div>
          </div>
          <h3 style="margin-top:8px;"><?= htmlspecialchars($m['name']); ?></h3>
          <p class="small-muted"><?= htmlspecialchars($m['description']); ?></p>
          <p class="price"><?= $price_display; ?></p>
          <!-- E1: icon + label "Estimasi:" -->
          <p class="small-muted">⏳ <strong>Estimasi:</strong> <?= htmlspecialchars($m['estimated_work_time']); ?></p>

          <!-- ambil button: ketika di-klik akan buka wizard dan preselect layanan -->
          <div style="margin-top:10px;">
            <button class="btn-primary pick-service" 
                    data-id="<?= $m['id_menu']; ?>" 
                    data-name="<?= htmlspecialchars($m['name'], ENT_QUOTES); ?>"
                    data-price="<?= $m['price']; ?>"
                    data-est="<?= htmlspecialchars($m['estimated_work_time'], ENT_QUOTES); ?>">
              Ambil
            </button>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<!-- ================= BOTTOM SHEET WIZARD (modal overlay) ================= -->
<div id="wizardOverlay" class="modal-overlay" aria-hidden="true">
  <div class="bottom-sheet" role="dialog" aria-modal="true">
    <div class="sheet-card">

      <!-- handle -->
      <div class="sheet-handle"></div>

      <!-- header bar (nav) -->
      <div class="sheet-header">
        AMBIL NOMOR ANTRIAN
      </div>

      <!-- wizard slider container -->
      <div class="wizard-container" id="wizardContainer">
        <!-- We'll render steps here; JS will manage transform -->
        <div class="wizard-step" data-step="1">
          <!-- Step 1: Pilih layanan + lihat estimate -->
          <div style="padding:8px;">
            <h3>Pilih Layanan</h3>
            <p class="small-muted">Pilih layanan yang sesuai, lalu lanjut ke pengisian data.</p>

            <!-- show selected service preview (updated by JS when user clicks a card) -->
            <div id="selectedPreview" class="card-compact" style="margin-top:12px;">
              <div id="sp-name" style="font-weight:600;">Belum memilih layanan</div>
              <div id="sp-price" class="small-muted"></div>
              <div id="sp-est" class="small-muted"></div>
            </div>

            <div style="margin-top:12px;">
              <p class="small-muted">Atau pilih layanan langsung dari daftar layanan di halaman.</p>
            </div>
          </div>
        </div>

        <div class="wizard-step" data-step="2" style="display:none;">
          <!-- Step 2: Isi data diri -->
          <div style="padding:8px;">
            <h3>Data Diri</h3>
            <p class="small-muted">Isi data supaya kami dapat menghubungi Anda.</p>

            <form id="step2form" onsubmit="return false;">
              <div class="form-grid">
                <div>
                  <label>Nama</label>
                  <input type="text" id="cust_nama" name="nama" placeholder="Nama lengkap" required>
                </div>
                <div>
                  <label>No. Telepon</label>
                  <input type="tel" id="cust_telepon" name="telepon" placeholder="08xxxxxxxxxx" required>
                </div>

                <div style="grid-column:span 2;">
                  <label>Alamat</label>
                  <textarea id="cust_alamat" name="alamat" rows="2" placeholder="Alamat lengkap" required></textarea>
                </div>

                <div style="grid-column:span 2;">
                  <label>Keluhan / Keterangan</label>
                  <textarea id="cust_keluhan" name="keluhan" rows="2" placeholder="Detail masalah" required></textarea>
                </div>

                <div style="grid-column:span 2;">
                  <label>Prioritas</label>
                  <select id="cust_priority" name="priority" required>
                    <option value="Normal" selected>Normal</option>
                    <option value="Urgent">Urgent</option>
                    <option value="Low">Low</option>
                  </select>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="wizard-step" data-step="3" style="display:none;">
          <!-- Step 3: Konfirmasi -->
          <div style="padding:8px;">
            <h3>Konfirmasi & Ambil Nomor</h3>
            <p class="small-muted">Cek kembali data kamu. Tekan "Ambil Antrian" untuk menyelesaikan.</p>

            <div class="card-compact" style="margin-top:8px;">
              <div style="font-weight:700;" id="confirm_service">-</div>
              <div id="confirm_price" class="small-muted"></div>
              <div id="confirm_est" class="small-muted"></div>
              <hr style="margin:8px 0;">
              <div><strong>Nama:</strong> <span id="confirm_nama"></span></div>
              <div><strong>Telepon:</strong> <span id="confirm_tel"></span></div>
              <div><strong>Alamat:</strong> <span id="confirm_alamat"></span></div>
              <div><strong>Keluhan:</strong> <span id="confirm_keluhan"></span></div>
              <div><strong>Prioritas:</strong> <span id="confirm_priority"></span></div>
            </div>

            <!-- final submit form (hidden) -->
            <form id="finalSubmitForm" action="simpan_antrian.php" method="POST" style="margin-top:12px;">
              <input type="hidden" name="id_menu" id="final_id_menu">
              <input type="hidden" name="nama" id="final_nama">
              <input type="hidden" name="telepon" id="final_telepon">
              <input type="hidden" name="alamat" id="final_alamat">
              <input type="hidden" name="keluhan" id="final_keluhan">
              <input type="hidden" name="priority" id="final_priority">

              <button type="submit" class="btn-primary" style="width:100%;">Ambil Antrian</button>
            </form>

          </div>
        </div>

      </div>

      <!-- footer controls (prev / stepper / next) -->
      <div class="wizard-controls">
        <div style="display:flex;gap:8px;align-items:center;">
          <button id="wizardPrev" class="btn-primary" style="background:#e6eefc;color:var(--primary-dark);">Kembali</button>
          <div class="stepper-dots" id="dotsContainer">
            <span class="active"></span>
            <span></span>
            <span></span>
          </div>
        </div>

        <div style="display:flex;gap:8px;">
          <button id="wizardNext" class="btn-primary">Lanjut</button>
          <button id="wizardClose" class="btn-primary" style="background:transparent;border:1px solid #cfe3ff;color:var(--primary-dark);">Tutup</button>
        </div>
      </div>

    </div> <!-- /.sheet-card -->
  </div> <!-- /.bottom-sheet -->
</div> <!-- /.modal-overlay -->

<!-- ================= FOOTER SMALL ================= -->
<footer style="padding:18px 0;margin-top:30px;">
  <div class="container center">
    <p style="color:#334155;">E-SPEED MACHINING • Jl. Contoh No.1 • Jam Operasional 09:00–17:00</p>
  </div>
</footer>

<!-- ================ SCRIPTS (inline, ready-to-run) ================ -->
<script>
/*
  Script notes:
  - Handles opening modal (wizard), auto-preselecting service when clicking a service card
  - Manages wizard steps (1..3) with smooth show/hide (fade+soft slide feel)
  - Fills confirmation fields and final hidden form for POST to simpan_antrian.php
  - Locks body scroll while modal is open
*/

// elements
const overlay = document.getElementById('wizardOverlay');
const openBtns = [document.getElementById('openWizardBtn'), document.getElementById('openWizardBtnHero')];
const pickButtons = document.querySelectorAll('.pick-service');
const wizardSteps = document.querySelectorAll('.wizard-step');
const nextBtn = document.getElementById('wizardNext');
const prevBtn = document.getElementById('wizardPrev');
const closeBtn = document.getElementById('wizardClose');
const dots = document.querySelectorAll('#dotsContainer span');

let currentStep = 1;
let selectedService = { id: null, name: null, price: null, est: null };

/* open modal */
function openWizard(prefSelect = null) {
  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
  if (prefSelect) preselectService(prefSelect);
  showStep(1);
}

/* close modal */
function closeWizard() {
  overlay.classList.remove('open');
  document.body.style.overflow = '';
}

/* preselect service (prefSelect may be object with data) */
function preselectService(pref) {
  if (!pref) return;
  selectedService.id = pref.id || null;
  selectedService.name = pref.name || null;
  selectedService.price = pref.price || null;
  selectedService.est = pref.est || null;
  // update preview
  document.getElementById('sp-name').innerText = selectedService.name || 'Belum memilih layanan';
  document.getElementById('sp-price').innerText = selectedService.price ? 'Rp ' + Number(selectedService.price).toLocaleString('id-ID') : '';
  document.getElementById('sp-est').innerText = selectedService.est || '';
}

/* show wizard step (1..3) */
function showStep(n) {
  currentStep = n;
  wizardSteps.forEach((el) => {
    const s = Number(el.getAttribute('data-step'));
    if (s === n) {
      el.style.display = 'block';
      el.style.opacity = 1;
    } else {
      el.style.display = 'none';
      el.style.opacity = 0;
    }
  });
  // update dots
  dots.forEach((d,i)=> d.classList.toggle('active', (i+1)===n) );
  // next/prev button text changes
  if (n === 3) nextBtn.style.display = 'none';
  else nextBtn.style.display = 'inline-block';
}

/* go next (from step 1 -> 2 -> 3) */
nextBtn.addEventListener('click', function(){
  if (currentStep === 1) {
    // require a service selected
    if (!selectedService.id) {
      alert('Pilih layanan terlebih dahulu (tekan tombol Ambil pada kartu layanan atau pilih layanan di halaman).');
      return;
    }
    showStep(2);
  } else if (currentStep === 2) {
    // validate step2 form entries (basic)
    const nama = document.getElementById('cust_nama').value.trim();
    const tel  = document.getElementById('cust_telepon').value.trim();
    const alamat = document.getElementById('cust_alamat').value.trim();
    const keluhan = document.getElementById('cust_keluhan').value.trim();
    if(!nama || !tel || !alamat || !keluhan) {
      alert('Mohon lengkapi semua field.');
      return;
    }
    // fill confirmation
    document.getElementById('confirm_service').innerText = selectedService.name;
    document.getElementById('confirm_price').innerText = 'Rp ' + Number(selectedService.price).toLocaleString('id-ID');
    document.getElementById('confirm_est').innerText = selectedService.est || '';
    document.getElementById('confirm_nama').innerText = nama;
    document.getElementById('confirm_tel').innerText = tel;
    document.getElementById('confirm_alamat').innerText = alamat;
    document.getElementById('confirm_keluhan').innerText = keluhan;
    document.getElementById('confirm_priority').innerText = document.getElementById('cust_priority').value;

    // prepare hidden final form inputs
    document.getElementById('final_id_menu').value = selectedService.id;
    document.getElementById('final_nama').value = nama;
    document.getElementById('final_telepon').value = tel;
    document.getElementById('final_alamat').value = alamat;
    document.getElementById('final_keluhan').value = keluhan;
    document.getElementById('final_priority').value = document.getElementById('cust_priority').value;

    showStep(3);
  }
});

/* prev */
prevBtn.addEventListener('click', function(){
  if(currentStep > 1) showStep(currentStep-1);
  else closeWizard();
});

/* close */
closeBtn.addEventListener('click', closeWizard);
overlay.addEventListener('click', function(e){
  if (e.target === overlay) closeWizard();
});

// attach open buttons
openBtns.forEach(b => {
  if (b) b.addEventListener('click', ()=> openWizard() );
});

// attach pick-service buttons in service cards
pickButtons.forEach(btn => {
  btn.addEventListener('click', function(){
    // read data attributes
    const id = this.getAttribute('data-id');
    const name = this.getAttribute('data-name');
    const price = this.getAttribute('data-price');
    const est = this.getAttribute('data-est');

    preselectService({ id: id, name: name, price: price, est: est });
    openWizard(); // open and go to step 1
  });
});

// disable default form submit on step2form (we use final form)
document.getElementById('step2form').addEventListener('submit', function(e){
  e.preventDefault();
});

// keyboard Esc to close
document.addEventListener('keydown', function(e){
  if (e.key === "Escape") closeWizard();
});
</script>

</body>
</html>
