document.addEventListener('DOMContentLoaded', function() {
    const antrianForm = document.getElementById('antrianForm');
    const successMessage = document.getElementById('successMessage');

    // 1. Logika Pemrosesan Form Antrian
    if (antrianForm) {
        antrianForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form di-submit secara default

            // --- SIMULASI PENGIRIMAN DATA ---
            
            // Mengambil data dari form
            const formData = new FormData(this);
            const nama = formData.get('nama');
            const telepon = formData.get('telepon');
            
            console.log(`Pemesanan antrian dari: ${nama}, Telp: ${telepon}`);
            
            // Sembunyikan form dan tampilkan pesan sukses
            antrianForm.style.display = 'none';
            successMessage.style.display = 'block';

            // Opsional: Kembali ke tampilan form setelah 8 detik
            setTimeout(() => {
                 antrianForm.style.display = 'block';
                 successMessage.style.display = 'none';
                 this.reset(); // Mengosongkan form
            }, 8000); 
        });
    }

    // 2. Efek Smooth Scroll untuk link navigasi
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            // Kecualikan tombol Pesan Antrian di navbar agar tidak terpengaruh smooth scroll
            if (this.classList.contains('btn-nav')) return; 

            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});