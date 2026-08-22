/**
 * SITKD Karangmekar — Welcome Page Core JavaScript
 * Tahun: 2026
 */

document.addEventListener('DOMContentLoaded', () => {
     // 1. MODUL NAVIGASI MOBILE (HAMBURGER DRAWER)
     initMobileMenu();

     // 2. MODUL TICKER PENGUMUMAN (PAUSE ON HOVER)
     initTickerControl();

     // 3. MODUL ANIMASI KETIKA DI-SCROLL (INTERSECTION OBSERVER)
     initScrollAnimations();

     // 4. MODUL CHART.JS INTERAKTIF (DATA DESA & ANGGARAN)
     // Dibungkus try-catch agar jika Chart.js belum loaded, script tidak crash
     try {
          if (typeof Chart !== 'undefined') {
               initVillageCharts();
          } else {
               console.warn('Chart.js tidak terdeteksi. Pastikan library CDN terpasang.');
          }
     } catch (error) {
          console.error('Gagal menginisialisasi grafik:', error);
     }
});

/**
 * Mendukung interaksi menu drawer saat layar hp/mobile
 */
function initMobileMenu() {
     const navToggle = document.getElementById('nav-toggle');
     const mobileMenu = document.getElementById('mobile-menu');
     const mobileOverlay = document.getElementById('mobile-overlay');
     const mobileLinks = document.querySelectorAll('.mobile-link');

     if (!navToggle || !mobileMenu) return;

     const toggleMenu = (shouldOpen) => {
          const isOpen = shouldOpen !== undefined ? shouldOpen : navToggle.getAttribute('aria-expanded') === 'false';

          navToggle.setAttribute('aria-expanded', isOpen);
          mobileMenu.setAttribute('aria-hidden', !isOpen);

          if (isOpen) {
               mobileMenu.classList.add('active');
               mobileOverlay.classList.add('active');
               document.body.style.overflow = 'hidden'; // Kunci scroll layar belakang
          } else {
               mobileMenu.classList.remove('active');
               mobileOverlay.classList.remove('active');
               document.body.style.overflow = ''; // Aktifkan scroll kembali
          }
     };

     // Event listener klik tombol hamburger
     navToggle.addEventListener('click', () => toggleMenu());

     // Tutup menu jika overlay transparan di luar klik
     mobileOverlay.addEventListener('click', () => toggleMenu(false));

     // Tutup menu otomatis jika salah satu link navigasi diklik
     mobileLinks.forEach(link => {
          link.addEventListener('click', () => toggleMenu(false));
     });
}

/**
 * Kontrol Ticker agar berhenti berjalan ketika di-hover cursor (nyaman dibaca warga)
 */
function initTickerControl() {
     const tickerTrack = document.querySelector('.ticker-track');
     if (!tickerTrack) return;

     tickerTrack.addEventListener('mouseenter', () => {
          tickerTrack.style.animationPlayState = 'paused';
     });

     tickerTrack.addEventListener('mouseleave', () => {
          tickerTrack.style.animationPlayState = 'running';
     });
}

/**
 * Memberikan animasi kemunculan elemen halus (fade-in up) saat di-scroll ke bawah
 */
function initScrollAnimations() {
     const animatedTargets = document.querySelectorAll('.stat-card, .chart-card, .layanan-card, .foto-item, .berita-article, .pamong-card');

     // Setup style awal elemen sebelum muncul lewat JS agar aman jika JS dimatikan user
     animatedTargets.forEach(el => {
          el.style.opacity = '0';
          el.style.transform = 'translateY(30px)';
          el.style.transition = 'opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1)';
     });

     const observerOptions = {
          root: null,
          threshold: 0.15, // Elemen mulai muncul ketika 15% areanya masuk layar
          rootMargin: '0px'
     };

     const scrollObserver = new IntersectionObserver((entries, observer) => {
          entries.forEach(entry => {
               if (entry.isIntersecting) {
                    const target = entry.target;
                    target.style.opacity = '1';
                    target.style.transform = 'translateY(0)';
                    observer.unobserve(target); // Matikan observer jika sudah muncul sekali
               }
          });
     }, observerOptions);

     animatedTargets.forEach(target => scrollObserver.observe(target));
}

/**
 * Setup Konfigurasi 6 Grafik Data Desa & Anggaran (Chart.js v4)
 */
function initVillageCharts() {
     // Opsi konfigurasi global chart agar seragam dan responsive
     const globalOptions = {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
               legend: { display: false } // Kita sembunyikan karena HTML sudah punya custom legend kustom bawaanmu
          }
     };

     // --- 1. CHART PERTUMBUHAN PENDUDUK (Line Chart) ---
     const ctxPenduduk = document.getElementById('chartPenduduk');
     if (ctxPenduduk) {
          new Chart(ctxPenduduk, {
               type: 'line',
               data: {
                    labels: ['2021', '2022', '2023', '2024', '2025'],
                    datasets: [
                         {
                              label: 'Total Penduduk',
                              data: [3180, 3250, 3310, 3390, 3450],
                              borderColor: '#1a6b4a',
                              backgroundColor: 'rgba(26, 107, 74, 0.1)',
                              tension: 0.3,
                              fill: true
                         },
                         {
                              label: 'Kepala Keluarga',
                              data: [1010, 1040, 1070, 1100, 1120],
                              borderColor: '#c47c1a',
                              backgroundColor: 'transparent',
                              tension: 0.3,
                              borderDash: [5, 5]
                         }
                    ]
               },
               options: globalOptions
          });
     }

     // --- 2. CHART DISTRIBUSI USIA (Bar Chart) ---
     const ctxUsia = document.getElementById('chartUsia');
     if (ctxUsia) {
          new Chart(ctxUsia, {
               type: 'bar',
               data: {
                    labels: ['0-14', '15-24', '25-54', '55-64', '65+'],
                    datasets: [
                         {
                              label: 'Laki-laki',
                              data: [340, 410, 680, 210, 120],
                              backgroundColor: '#1d6fa4',
                              borderRadius: 6,
                         },
                         {
                              label: 'Perempuan',
                              data: [310, 390, 650, 190, 140],
                              backgroundColor: '#d4537e',
                              borderRadius: 6,
                         }
                    ]
               },
               options: {
                    ...globalOptions,
                    scales: {
                         x: { stacked: false },
                         y: { stacked: false }
                    }
               }
          });
     }

     // --- 3. CHART DATA KEMISKINAN (Doughnut Chart) ---
     const ctxKemiskinan = document.getElementById('chartKemiskinan');
     if (ctxKemiskinan) {
          new Chart(ctxKemiskinan, {
               type: 'doughnut',
               data: {
                    labels: ['Sejahtera', 'Rentan Miskin', 'Miskin'],
                    datasets: [{
                         data: [73.2, 18.4, 8.4],
                         backgroundColor: ['#1a6b4a', '#c47c1a', '#c0392b'],
                         borderWidth: 2,
                         borderColor: '#ffffff'
                    }]
               },
               options: {
                    ...globalOptions,
                    cutout: '70%'
               }
          });
     }

     // --- 4. CHART TINGKAT PENDIDIKAN (Polar Area Chart / Radar) ---
     const ctxPendidikan = document.getElementById('chartPendidikan');
     if (ctxPendidikan) {
          new Chart(ctxPendidikan, {
               type: 'bar',
               data: {
                    labels: ['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'Diploma/S1+'],
                    datasets: [{
                         data: [12, 28, 25, 30, 15], // Skala persentase %
                         backgroundColor: ['#94a3b8', '#f59e0b', '#3b82f6', '#10b981', '#6366f1'],
                         borderRadius: 8
                    }]
               },
               options: {
                    ...globalOptions,
                    indexAxis: 'y', // Mengubah menjadi bar horizontal agar hemat ruang mobile
               }
          });
     }

     // --- 5. CHART REALISASI ANGGARAN PER BIDANG (Horizontal Bar Grouped) ---
     const ctxAnggaran = document.getElementById('chartAnggaran');
     if (ctxAnggaran) {
          new Chart(ctxAnggaran, {
               type: 'bar',
               data: {
                    labels: ['Infrastruktur', 'Pendidikan', 'Kesehatan'],
                    datasets: [
                         {
                              label: 'Alokasi (Juta Rp)',
                              data: [600, 220, 300],
                              backgroundColor: '#e2e8f0',
                              borderRadius: 4
                         },
                         {
                              label: 'Realisasi (Juta Rp)',
                              data: [412, 185, 276],
                              backgroundColor: '#16a34a',
                              borderRadius: 4
                         }
                    ]
               },
               options: {
                    ...globalOptions,
                    indexAxis: 'y',
                    scales: {
                         x: { grid: { display: false } }
                    }
               }
          });
     }

     // --- 6. CHART PROPORSI APBDES PIE (Pie Chart Ringkasan) ---
     const ctxAnggaranPie = document.getElementById('chartAnggaranPie');
     if (ctxAnggaranPie) {
          new Chart(ctxAnggaranPie, {
               type: 'pie',
               data: {
                    labels: ['Dana Desa (DD)', 'Alokasi Dana Desa (ADD)', 'Bagi Hasil Pajak'],
                    datasets: [{
                         data: [60.7, 30.0, 9.3],
                         backgroundColor: ['#0f766e', '#0284c7', '#f59e0b'],
                         borderWidth: 1
                    }]
               },
               options: globalOptions
          });
     }
}