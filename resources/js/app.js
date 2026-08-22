import Quill from 'quill';

document.addEventListener('DOMContentLoaded', function () {
     // 1. Inisialisasi Quill Editor
     const editorContainer = document.querySelector('#wysiwyg-editor');
     if (editorContainer) {
          const quill = new Quill(editorContainer, {
               theme: 'snow',
               modules: {
                    toolbar: [
                         [{ 'header': [2, 3, false] }],
                         ['bold', 'italic'],
                         [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                         ['link', 'clean']
                    ]
               }
          });

          const descArea = document.getElementById('description');
          if (descArea && descArea.value) {
               quill.root.innerHTML = descArea.value;
          }

          quill.on('text-change', () => {
               if (descArea) descArea.value = quill.root.innerHTML;
          });
     }

     // 2. Custom Alert Modal Control
     const alertModal = document.getElementById('custom-alert-modal');
     const alertCard = document.getElementById('custom-alert-card');
     const alertTitle = document.getElementById('alert-title');
     const alertMessage = document.getElementById('alert-message');
     const closeAlertBtn = document.getElementById('close-alert-btn');

     function showAlert(title, message) {
          if (!alertModal || !alertCard) {
               alert(`${title}\n\n${message}`); // Fallback jika modal tidak ada di halaman
               return;
          }
          alertTitle.textContent = title;
          alertMessage.textContent = message;
          alertModal.classList.remove('opacity-0', 'pointer-events-none');
          alertCard.classList.remove('scale-95');
          alertCard.classList.add('scale-100');
     }

     if (closeAlertBtn && alertModal && alertCard) {
          closeAlertBtn.addEventListener('click', function () {
               alertModal.classList.add('opacity-0', 'pointer-events-none');
               alertCard.classList.remove('scale-100');
               alertCard.classList.add('scale-95');
          });
     }

     const coverInput = document.getElementById('cover_image');
     const galleryInput = document.getElementById('gallery');
     const coverSizeInfo = document.getElementById('cover-size-info');
     const gallerySizeInfo = document.getElementById('gallery-size-info');
     const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB

     function formatFileSize(bytes) {
          if (bytes >= 1048576) {
               return (bytes / 1048576).toFixed(2) + ' MB';
          } else if (bytes >= 1024) {
               return (bytes / 1024).toFixed(2) + ' KB';
          }
          return bytes + ' Bytes';
     }

     // 3. Live Preview Icon & Auto-Select Input
     const iconInput = document.getElementById('icon');
     const previewIconElement = document.getElementById('preview-icon-element');
     const previewCardIcon = document.getElementById('preview-card-icon');
     const valueInput = document.getElementById('value');

     if (iconInput && previewIconElement) {
          function updateIconPreview() {
               let val = iconInput.value.trim();
               if (val && !val.startsWith('ti-')) {
                    val = 'ti-' + val.replace(/^ti-/, '');
               }
               const finalIcon = val || 'ti-trophy';
               previewIconElement.className = 'ti ' + finalIcon;
               if (previewCardIcon) previewCardIcon.className = 'ti ' + finalIcon;
          }

          iconInput.addEventListener('input', updateIconPreview);
          updateIconPreview();
     }

     if (valueInput) {
          valueInput.addEventListener('focus', function () {
               this.select();
          });
     }

     const categoryInput = document.getElementById('category');
     if (categoryInput) {
          categoryInput.addEventListener('input', e => {
               const el = document.getElementById('preview-category');
               if (el) el.textContent = e.target.value || 'Tingkatan';
          });
     }

     const yearInput = document.getElementById('year');
     if (yearInput) {
          yearInput.addEventListener('input', e => {
               const el = document.getElementById('preview-year');
               if (el) el.textContent = e.target.value || '2026';
          });
     }

     const titleInput = document.getElementById('title');
     if (titleInput) {
          titleInput.addEventListener('input', e => {
               const el = document.getElementById('card-preview-title');
               if (el) el.textContent = e.target.value || 'Judul Kejuaraan Siswa';
          });
     }

     // --- Live Preview untuk Modul Guru & Staff ---
     const guruNameInput = document.getElementById('name');
     const guruJabatanInput = document.getElementById('jabatan');
     const guruCategorySelect = document.getElementById('category');
     const guruSubInput = document.getElementById('sub');
     const cardPreviewTitle = document.getElementById('card-preview-title');
     const previewCategory = document.getElementById('preview-category');
     const previewSub = document.getElementById('preview-sub');

     if (guruNameInput) {
          guruNameInput.addEventListener('input', e => {
               if (cardPreviewTitle) cardPreviewTitle.textContent = e.target.value || 'Nama Guru';
          });
     }

     if (guruJabatanInput) {
          guruJabatanInput.addEventListener('input', e => {
               if (previewSub && !guruSubInput?.value) {
                    previewSub.textContent = e.target.value || 'Jabatan Utama';
               }
          });
     }

     if (guruCategorySelect) {
          guruCategorySelect.addEventListener('change', e => {
               if (previewCategory) previewCategory.textContent = e.target.value.toUpperCase();
          });
     }

     if (guruSubInput) {
          guruSubInput.addEventListener('input', e => {
               if (previewSub) previewSub.textContent = e.target.value || 'Sub Keterangan';
          });
     }

     // --- Live Preview untuk Form Galeri (Admin) ---
     const galleryTitleInput = document.getElementById('title');
     const galleryCategoryInput = document.getElementById('category');
     const galleryCaptionInput = document.getElementById('caption');
     const previewGalleryTitle = document.getElementById('preview-gallery-title');
     const previewGalleryCategory = document.getElementById('preview-gallery-category');

     if (galleryTitleInput && previewGalleryTitle) {
          galleryTitleInput.addEventListener('input', e => {
               previewGalleryTitle.textContent = e.target.value || 'Keterangan Foto Galeri';
          });
     }

     if (galleryCategoryInput && previewGalleryCategory) {
          galleryCategoryInput.addEventListener('input', e => {
               previewGalleryCategory.textContent = e.target.value || 'Kegiatan';
          });
     }

     // 4. Live Preview Chart (Demografi Siswa)
     const maleInput = document.getElementById('male_count');
     const femaleInput = document.getElementById('female_count');
     const previewMale = document.getElementById('preview-male');
     const previewFemale = document.getElementById('preview-female');
     const totalStudents = document.getElementById('total-students');
     const barMale = document.getElementById('bar-male');
     const barFemale = document.getElementById('bar-female');
     const percentMale = document.getElementById('percent-male');
     const percentFemale = document.getElementById('percent-female');

     if (maleInput && femaleInput) {
          function updateChartPreview() {
               const maleVal = parseInt(maleInput.value) || 0;
               const femaleVal = parseInt(femaleInput.value) || 0;
               const total = maleVal + femaleVal;

               if (previewMale) previewMale.textContent = maleVal;
               if (previewFemale) previewFemale.textContent = femaleVal;
               if (totalStudents) totalStudents.textContent = `Total: ${total} Siswa`;

               let pMale = 0;
               let pFemale = 0;

               if (total > 0) {
                    pMale = Math.round((maleVal / total) * 100);
                    pFemale = 100 - pMale;
               }

               if (barMale) barMale.style.width = `${pMale}%`;
               if (barFemale) barFemale.style.width = `${pFemale}%`;
               if (percentMale) percentMale.textContent = `${pMale}%`;
               if (percentFemale) percentFemale.textContent = `${pFemale}%`;
          }

          maleInput.addEventListener('input', updateChartPreview);
          femaleInput.addEventListener('input', updateChartPreview);
          updateChartPreview();
     }

     // 5. Validasi Interaktif Password
     const passwordInput = document.getElementById('password');
     const confirmInput = document.getElementById('password_confirmation');
     const strengthBar = document.getElementById('password-strength-bar');
     const strengthText = document.getElementById('password-strength-text');
     const ruleLength = document.getElementById('rule-length');
     const ruleNumber = document.getElementById('rule-number');
     const matchWarning = document.getElementById('password-match-warning');
     const togglePassword = document.getElementById('toggle-password');
     const eyeIcon = document.getElementById('eye-icon');

     if (passwordInput && togglePassword && eyeIcon) {
          togglePassword.addEventListener('click', function () {
               const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
               passwordInput.setAttribute('type', type);
               eyeIcon.classList.toggle('ti-eye');
               eyeIcon.classList.toggle('ti-eye-off');
          });

          passwordInput.addEventListener('input', function () {
               const val = passwordInput.value;
               let score = 0;

               if (val.length >= 8) {
                    score += 1;
                    if (ruleLength) {
                         ruleLength.classList.remove('text-slate-500');
                         ruleLength.classList.add('text-emerald-600', 'font-semibold');
                         const iconEl = ruleLength.querySelector('i');
                         if (iconEl) iconEl.className = 'ti ti-circle-check text-emerald-600';
                    }
               } else {
                    if (ruleLength) {
                         ruleLength.classList.remove('text-emerald-600', 'font-semibold');
                         ruleLength.classList.add('text-slate-500');
                         const iconEl = ruleLength.querySelector('i');
                         if (iconEl) iconEl.className = 'ti ti-circle text-slate-300';
                    }
               }

               if (/\d/.test(val)) {
                    score += 1;
                    if (ruleNumber) {
                         ruleNumber.classList.remove('text-slate-500');
                         ruleNumber.classList.add('text-emerald-600', 'font-semibold');
                         const iconEl = ruleNumber.querySelector('i');
                         if (iconEl) iconEl.className = 'ti ti-circle-check text-emerald-600';
                    }
               } else {
                    if (ruleNumber) {
                         ruleNumber.classList.remove('text-emerald-600', 'font-semibold');
                         ruleNumber.classList.add('text-slate-500');
                         const iconEl = ruleNumber.querySelector('i');
                         if (iconEl) iconEl.className = 'ti ti-circle text-slate-300';
                    }
               }

               if (strengthBar && strengthText) {
                    if (val.length === 0) {
                         strengthBar.style.width = '0%';
                         strengthText.textContent = 'Belum diisi';
                         strengthText.className = 'font-bold text-slate-400';
                    } else if (score === 1) {
                         strengthBar.style.width = '50%';
                         strengthBar.className = 'bg-amber-500 h-full transition-all duration-300';
                         strengthText.textContent = 'Lemah';
                         strengthText.className = 'font-bold text-amber-600';
                    } else if (score >= 2) {
                         strengthBar.style.width = '100%';
                         strengthBar.className = 'bg-emerald-600 h-full transition-all duration-300';
                         strengthText.textContent = 'Kuat';
                         strengthText.className = 'font-bold text-emerald-600';
                    }
               }

               checkMatch();
          });
     }

     if (confirmInput) {
          confirmInput.addEventListener('input', checkMatch);
     }

     function checkMatch() {
          if (passwordInput && confirmInput && matchWarning) {
               if (confirmInput.value.length > 0 && passwordInput.value !== confirmInput.value) {
                    matchWarning.classList.remove('hidden');
                    confirmInput.classList.add('border-rose-500');
               } else {
                    matchWarning.classList.add('hidden');
                    confirmInput.classList.remove('border-rose-500');
               }
          }
     }

     // 6. Cover Image Validation & Kompresi (General Jpeg)
     if (coverInput) {
          coverInput.addEventListener('change', function (e) {
               const file = e.target.files[0];
               if (!file) {
                    if (coverSizeInfo) coverSizeInfo.classList.add('hidden');
                    return;
               }

               if (file.size > MAX_FILE_SIZE) {
                    showAlert('Foto Utama Terlalu Besar', 'Ukuran foto utama melebihi batas maksimal 2 MB! Harap pilih file yang lebih kecil.');
                    this.value = '';
                    const imgCover = document.getElementById('card-preview-cover');
                    const placeholder = document.getElementById('card-placeholder');
                    if (imgCover) imgCover.classList.add('hidden');
                    if (placeholder) placeholder.classList.remove('hidden');
                    if (coverSizeInfo) coverSizeInfo.classList.add('hidden');
                    return;
               }

               const originalSizeStr = formatFileSize(file.size);
               const reader = new FileReader();
               reader.onload = evt => {
                    const img = document.getElementById('card-preview-cover');
                    const placeholder = document.getElementById('card-placeholder');
                    if (img) {
                         img.src = evt.target.result;
                         img.classList.remove('hidden');
                    }
                    if (placeholder) placeholder.classList.add('hidden');
               }
               reader.readAsDataURL(file);

               compressImage(file, 1200, 800, 0.75, function (compressedBlob) {
                    const compressedSizeStr = formatFileSize(compressedBlob.size);
                    if (coverSizeInfo) {
                         coverSizeInfo.innerHTML = `<span class="font-semibold text-emerald-600"><i class="ti ti-check"></i> Asli: ${originalSizeStr} → Kompresi: ${compressedSizeStr}</span>`;
                         coverSizeInfo.classList.remove('hidden');
                    }
               });
          });
     }

     // 7. Gallery Images Validation & Kompresi
     if (galleryInput) {
          galleryInput.addEventListener('change', function (e) {
               const files = Array.from(e.target.files);
               if (gallerySizeInfo) gallerySizeInfo.innerHTML = '';

               if (files.length > 3) {
                    showAlert('Batas Jumlah Galeri', 'Maksimal hanya diperbolehkan memilih 3 foto galeri sekaligus!');
                    this.value = '';
                    if (gallerySizeInfo) gallerySizeInfo.classList.add('hidden');
                    return;
               }

               let invalidFile = false;
               files.forEach(file => {
                    if (file.size > MAX_FILE_SIZE) invalidFile = true;
               });

               if (invalidFile) {
                    showAlert('Foto Galeri Terlalu Besar', 'Salah satu foto galeri melebihi batas maksimal 2 MB! Harap pilih ulang file yang lebih kecil.');
                    this.value = '';
                    if (gallerySizeInfo) gallerySizeInfo.classList.add('hidden');
                    return;
               }

               if (files.length > 0) {
                    if (gallerySizeInfo) gallerySizeInfo.classList.remove('hidden');
                    files.forEach((file, idx) => {
                         const origStr = formatFileSize(file.size);
                         compressImage(file, 1200, 800, 0.75, function (blob) {
                              const compStr = formatFileSize(blob.size);
                              const item = document.createElement('div');
                              item.className = 'font-semibold text-emerald-600';
                              item.innerHTML = `<i class="ti ti-check"></i> Foto ${idx + 1}: ${origStr} → Kompresi: ${compStr}`;
                              if (gallerySizeInfo) gallerySizeInfo.appendChild(item);
                         });
                    });
               } else {
                    if (gallerySizeInfo) gallerySizeInfo.classList.add('hidden');
               }
          });
     }

     // 8. Lightbox & Observer untuk Galeri Publik
     window.openLightbox = function (src, caption) {
          const imgEl = document.getElementById('lightbox-img');
          const captionEl = document.getElementById('lightbox-caption');
          const lightbox = document.getElementById('gallery-lightbox');

          if (imgEl && captionEl && lightbox) {
               imgEl.src = src;
               captionEl.innerText = caption;
               lightbox.classList.remove('hidden');
               lightbox.classList.add('flex');
          }
     }

     window.closeLightbox = function () {
          const lightbox = document.getElementById('gallery-lightbox');
          if (lightbox) {
               lightbox.classList.add('hidden');
               lightbox.classList.remove('flex');
          }
     }

     const galeriObserver = new IntersectionObserver((entries, observerInstance) => {
          entries.forEach(entry => {
               if (entry.isIntersecting) {
                    const el = entry.target;
                    el.classList.remove('opacity-0', 'translate-y-8', '-translate-y-6');
                    el.classList.add('opacity-100', 'translate-y-0');
                    observerInstance.unobserve(el);
               }
          });
     }, { root: null, threshold: 0.15 });

     document.querySelectorAll('#galeri .reveal-item, #galeri .reveal-card').forEach(el => {
          galeriObserver.observe(el);
     });

     // Helper Kompresi Gambar Client-Side (Format JPEG standard)
     function compressImage(file, maxWidth, maxHeight, quality, callback) {
          const reader = new FileReader();
          reader.readAsDataURL(file);
          reader.onload = function (event) {
               const img = new Image();
               img.src = event.target.result;
               img.onload = function () {
                    let width = img.width;
                    let height = img.height;

                    if (width > maxWidth) {
                         height = Math.round((height * maxWidth) / width);
                         width = maxWidth;
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob(function (blob) {
                         callback(blob);
                    }, 'image/jpeg', quality);
               };
          };
     }

     // =========================================================================
     // 9. TAMBAHAN BARU: Auto Compress & Preview untuk Halaman Pengaturan (WebP)
     // =========================================================================

     // Fungsi Kompresi Khusus ke WebP
     window.compressToWebp = function (file) {
          return new Promise((resolve, reject) => {
               const reader = new FileReader();
               reader.readAsDataURL(file);
               reader.onload = event => {
                    const img = new Image();
                    img.src = event.target.result;
                    img.onload = () => {
                         const canvas = document.createElement('canvas');
                         const MAX_WIDTH = 1920;
                         const MAX_HEIGHT = 1080;
                         let width = img.width;
                         let height = img.height;

                         if (width > height) {
                              if (width > MAX_WIDTH) {
                                   height *= MAX_WIDTH / width;
                                   width = MAX_WIDTH;
                              }
                         } else {
                              if (height > MAX_HEIGHT) {
                                   width *= MAX_HEIGHT / height;
                                   height = MAX_HEIGHT;
                              }
                         }

                         canvas.width = width;
                         canvas.height = height;
                         const ctx = canvas.getContext('2d');
                         ctx.drawImage(img, 0, 0, width, height);

                         canvas.toBlob((blob) => {
                              if (blob) {
                                   let newFileName = file.name.replace(/\.[^/.]+$/, "") + ".webp";
                                   let newFile = new File([blob], newFileName, { type: 'image/webp' });
                                   resolve(newFile);
                              } else {
                                   reject(new Error('Canvas to Blob failed'));
                              }
                         }, 'image/webp', 0.8);
                    };
               };
               reader.onerror = error => reject(error);
          });
     }

     // Dipanggil oleh event onchange di tag input file Pengaturan
     window.processImage = async function (event, previewElementId, placeholderId = null) {
          const fileInput = event.target;
          const file = fileInput.files[0];

          if (!file) return;

          if (!file.type.match('image.*')) {
               showAlert('Format File Salah', 'File yang diunggah harus berupa gambar (JPG, PNG, WEBP).');
               fileInput.value = '';
               return;
          }

          try {
               // Panggil fungsi kompres ke WebP
               const compressedFile = await window.compressToWebp(file);

               if (compressedFile.size > MAX_FILE_SIZE) {
                    showAlert('Gambar Terlalu Besar', 'Gambar ditolak! Ukuran file setelah optimasi masih melebihi 2MB. Silakan gunakan gambar yang lebih kecil.');
                    fileInput.value = '';
                    return;
               }

               // Ganti file di DOM
               const dataTransfer = new DataTransfer();
               dataTransfer.items.add(compressedFile);
               fileInput.files = dataTransfer.files;

               // Update Preview Visual
               const previewImg = document.getElementById(previewElementId);
               if (previewImg) {
                    previewImg.src = URL.createObjectURL(compressedFile);
                    previewImg.classList.remove('hidden');
               }

               if (placeholderId) {
                    const placeholder = document.getElementById(placeholderId);
                    if (placeholder) placeholder.classList.add('hidden');
               }

          } catch (error) {
               console.error(error);
               showAlert('Gagal Memproses Gambar', 'Terjadi kesalahan saat memproses gambar. Silakan coba gambar lain.');
               fileInput.value = '';
          }
     }
     // =========================================================================
     // Live Preview untuk Icon Tabler (Floating Features Bar) - Otomatis Saat Diketik
     // =========================================================================
     window.updateIconDisplay = function (inputId, iconElementId) {
          const input = document.getElementById(inputId);
          const icon = document.getElementById(iconElementId);

          if (input && icon) {
               let val = input.value.trim();
               if (val) {
                    // Bersihkan jika user mengetik 'ti-' atau spasi berlebih
                    let cleanVal = val.replace(/^ti\s+/, '').replace(/^ti-/, '');
                    icon.className = 'ti ti-' + cleanVal;
               } else {
                    icon.className = 'ti ti-star'; // Fallback icon jika kosong
               }
          }
     }
});