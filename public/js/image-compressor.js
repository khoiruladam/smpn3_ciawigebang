/**
 * Image Compressor — Kompresi gambar otomatis di sisi client (browser)
 * Menggunakan Canvas API murni tanpa library tambahan.
 *
 * Digunakan di semua form upload admin SMPN 3 Ciawigebang.
 * Include file ini di layout admin, lalu panggil initImageCompressor()
 * setelah DOM ready.
 *
 * Fitur:
 * - Resize resolusi berlebih (maks 1920px default)
 * - Re-encode ke WebP (fallback JPEG) dengan quality adaptif
 * - Target ukuran akhir ≤ 1MB
 * - Indikator loading saat proses kompresi
 * - Support single dan multiple file input
 */
(function () {
    'use strict';

    // === Konfigurasi Default ===
    const DEFAULTS = {
        maxWidth: 1920,
        maxHeight: 1920,
        initialQuality: 0.82,
        minQuality: 0.4,
        maxSizeBytes: 1024 * 1024, // 1MB
    };

    // Deteksi dukungan WebP encode
    const _supportsWebP = (function () {
        try {
            const c = document.createElement('canvas');
            c.width = 1; c.height = 1;
            return c.toDataURL('image/webp').indexOf('data:image/webp') === 0;
        } catch (e) { return false; }
    })();
    const OUTPUT_TYPE = _supportsWebP ? 'image/webp' : 'image/jpeg';
    const OUTPUT_EXT = _supportsWebP ? '.webp' : '.jpg';

    /**
     * Kompres satu file gambar.
     * @param {File} file
     * @param {Object} opts — override untuk DEFAULTS
     * @returns {Promise<File>}
     */
    function compressImage(file, opts) {
        opts = Object.assign({}, DEFAULTS, opts || {});

        // Skip file non-gambar atau yang sudah kecil
        if (!file.type.startsWith('image/')) return Promise.resolve(file);
        if (file.size <= opts.maxSizeBytes) {
            // Tetap resize jika perlu, tapi jangan turunkan quality
            // Untuk file kecil, biarkan saja
        }

        return new Promise(function (resolve) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = new Image();
                img.onload = function () {
                    _processImage(img, file, opts, resolve);
                };
                img.onerror = function () { resolve(file); };
                img.src = e.target.result;
            };
            reader.onerror = function () { resolve(file); };
            reader.readAsDataURL(file);
        });
    }

    function _processImage(img, originalFile, opts, resolve) {
        var width = img.naturalWidth;
        var height = img.naturalHeight;

        // Resize jika melebihi batas dimensi
        if (width > opts.maxWidth || height > opts.maxHeight) {
            var ratio = Math.min(opts.maxWidth / width, opts.maxHeight / height);
            width = Math.round(width * ratio);
            height = Math.round(height * ratio);
        }

        var canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        var ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, width, height);

        // Coba kompresi dengan quality awal, turunkan jika masih terlalu besar
        _tryCompress(canvas, originalFile, opts.initialQuality, opts, resolve);
    }

    function _tryCompress(canvas, originalFile, quality, opts, resolve) {
        canvas.toBlob(function (blob) {
            if (!blob) { resolve(originalFile); return; }

            if (blob.size > opts.maxSizeBytes && quality > opts.minQuality) {
                // Kurangi quality 10% dan coba lagi
                _tryCompress(canvas, originalFile, quality - 0.1, opts, resolve);
                return;
            }

            // Buat File baru dari blob
            var newName = originalFile.name.replace(/\.[^.]+$/, OUTPUT_EXT);
            var compressedFile = new File([blob], newName, {
                type: OUTPUT_TYPE,
                lastModified: Date.now()
            });

            resolve(compressedFile);
        }, OUTPUT_TYPE, quality);
    }

    /**
     * Inisialisasi: intercept form submit untuk kompres gambar sebelum kirim.
     * Otomatis menarget semua <form> yang punya <input type="file" accept="image/*">
     */
    function initImageCompressor() {
        var forms = document.querySelectorAll('form');

        forms.forEach(function (form) {
            var fileInputs = form.querySelectorAll('input[type="file"][accept*="image"]');
            if (fileInputs.length === 0) return;

            // Tambahkan badge info di bawah setiap file input (jika belum ada)
            fileInputs.forEach(function (input) {
                if (input.dataset.compressorAttached) return;
                input.dataset.compressorAttached = 'true';

                var hint = document.createElement('p');
                hint.className = 'text-[10px] text-blue-600/70 mt-1 flex items-center gap-1';
                hint.innerHTML = '<i class="ti ti-photo-down text-xs"></i> Gambar akan dikompres otomatis (maks 1MB)';
                // Sisipkan setelah input, tapi sebelum error message jika ada
                if (input.nextElementSibling && input.nextElementSibling.classList.contains('text-rose-500')) {
                    input.parentNode.insertBefore(hint, input.nextElementSibling);
                } else {
                    input.parentNode.insertBefore(hint, input.nextSibling);
                }
            });

            // Intercept submit
            form.addEventListener('submit', function (e) {
                // Jangan intercept jika sudah diproses
                if (form.dataset.compressionDone === 'true') return;

                // Cek apakah ada file yang perlu dikompres
                var hasFiles = false;
                fileInputs.forEach(function (input) {
                    if (input.files && input.files.length > 0) hasFiles = true;
                });
                if (!hasFiles) return; // Tidak ada file, biarkan submit normal

                e.preventDefault();

                // Tampilkan overlay loading
                var overlay = _createLoadingOverlay();
                form.style.position = 'relative';
                form.appendChild(overlay);

                // Disable tombol submit
                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.dataset.originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="ti ti-loader-2 animate-spin text-base"></i> Mengompres gambar...';
                }

                // Kompres semua file di semua input
                var promises = [];

                fileInputs.forEach(function (input) {
                    if (!input.files || input.files.length === 0) return;

                    var inputPromise = _compressInputFiles(input);
                    promises.push(inputPromise);
                });

                Promise.all(promises).then(function () {
                    // Hapus overlay, tandai selesai, submit form
                    if (overlay.parentNode) overlay.parentNode.removeChild(overlay);
                    form.dataset.compressionDone = 'true';
                    form.submit();
                }).catch(function () {
                    // Gagal compress? Submit apa adanya
                    if (overlay.parentNode) overlay.parentNode.removeChild(overlay);
                    form.dataset.compressionDone = 'true';
                    form.submit();
                });
            });
        });
    }

    /**
     * Kompres semua file di satu input element, ganti files-nya.
     */
    function _compressInputFiles(input) {
        var files = Array.from(input.files);
        var compressedPromises = files.map(function (file) {
            // Baca max-width dari data attribute jika ada
            var maxW = parseInt(input.dataset.compressMaxWidth) || DEFAULTS.maxWidth;
            return compressImage(file, { maxWidth: maxW, maxHeight: maxW });
        });

        return Promise.all(compressedPromises).then(function (compressedFiles) {
            // Ganti file di input menggunakan DataTransfer API
            try {
                var dt = new DataTransfer();
                compressedFiles.forEach(function (f) { dt.items.add(f); });
                input.files = dt.files;
            } catch (err) {
                // Fallback: browser lama tidak support DataTransfer — submit file asli
                console.warn('ImageCompressor: DataTransfer not supported, uploading originals.');
            }
        });
    }

    /**
     * Buat overlay loading semi-transparan.
     */
    function _createLoadingOverlay() {
        var overlay = document.createElement('div');
        overlay.className = 'absolute inset-0 bg-white/80 z-50 flex flex-col items-center justify-center rounded-2xl';
        overlay.innerHTML =
            '<div class="flex flex-col items-center gap-3">' +
            '  <div class="w-10 h-10 border-3 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>' +
            '  <p class="text-sm font-semibold text-slate-700">Mengompres gambar...</p>' +
            '  <p class="text-xs text-slate-400">Harap tunggu sebentar</p>' +
            '</div>';
        return overlay;
    }

    // Auto-init saat DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initImageCompressor);
    } else {
        initImageCompressor();
    }

    // Expose ke global scope untuk penggunaan manual jika diperlukan
    window.ImageCompressor = {
        compress: compressImage,
        init: initImageCompressor
    };
})();
