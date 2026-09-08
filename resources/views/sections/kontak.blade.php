{{-- resources/views/sections/kontak.blade.php --}}
@php
    $alamat = setting('footer_address', 'Jl. Raya Ciawigebang, Kuningan, Jawa Barat');
    $telepon = setting('footer_phone', '(0232) 123456');
    $email = setting('footer_email', 'info@smpn3ciawigebang.sch.id');
    $jamOperasional = setting('operational_weekday', 'Senin - Jumat (07.00 - 15.00)');
@endphp

<section id="kontak" class="py-12 sm:py-16 md:py-24 bg-slate-50 relative z-20 border-t border-slate-200/80"
    aria-labelledby="h-kontak">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Seksi -->
        <div class="reveal-item opacity-0 -translate-y-6 transition-all duration-700 max-w-2xl mb-8 sm:mb-12">
            <span
                class="inline-block px-3 py-1 rounded-md bg-blue-100 text-blue-800 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2.5 sm:mb-3">
                Hubungi Kami
            </span>
            <h2 id="h-kontak" class="font-serif text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 leading-tight">
                Kontak & Lokasi
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2 leading-relaxed">
                Silakan hubungi kami atau kirim pesan untuk informasi seputar sekolah dan layanan pendidikan.
            </p>
        </div>

        <!-- Grid Informasi Kontak & Form Pesan (Seimbang 6 : 6) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-stretch">

            <!-- KIRI: Google Maps & Informasi Kontak (6 Kolom) -->
            <div
                class="reveal-card opacity-0 translate-y-8 transition-all duration-700 lg:col-span-6 bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 md:p-8 shadow-xs flex flex-col justify-between space-y-6">

                <div class="space-y-6">
                    <h3
                        class="font-serif text-lg sm:text-xl font-bold text-slate-900 pb-3 sm:pb-4 border-b border-slate-100 flex items-center justify-between">
                        <span>Lokasi & Informasi</span>
                        <i class="ti ti-map-pin text-blue-600 text-lg"></i>
                    </h3>

                    <!-- Google Maps Embed Container -->
                    <div
                        class="w-full h-56 sm:h-64 rounded-xl overflow-hidden border border-slate-200 shadow-inner relative bg-slate-100">
                        @php
                            $defaultMap =
                                'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.551529329767!2d108.4776!3d-6.9467!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTYnNDguMSJTIDEwOMKwMjgnMzkuNCJF!5e0!3m2!1sid!2sid!4v1600000000000!5m2!1sid!2sid';
                            $mapUrl = setting('footer_map_url') ? setting('footer_map_url') : $defaultMap;
                        @endphp
                        <iframe src="{{ $mapUrl }}" class="w-full h-full border-0" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Sekolah di Google Maps"></iframe>
                    </div>

                    <!-- Informasi Kontak Detail -->
                    <div class="space-y-3.5 text-xs sm:text-sm">
                        <div class="flex items-start gap-3 text-slate-700">
                            <i class="ti ti-map-pin text-blue-600 text-lg shrink-0 mt-0.5"></i>
                            <span class="leading-snug">{{ $alamat }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-700">
                            <i class="ti ti-phone text-blue-600 text-lg shrink-0"></i>
                            <span>{{ $telepon }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-700">
                            <i class="ti ti-mail text-blue-600 text-lg shrink-0"></i>
                            <span class="break-all">{{ $email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Jam Operasional di Bagian Bawah Kotak Kiri -->
                <div
                    class="pt-4 border-t border-slate-100 flex items-center gap-3 text-slate-600 text-[11px] sm:text-xs font-medium bg-slate-50 rounded-xl p-3">
                    <i class="ti ti-clock text-blue-600 text-base sm:text-lg shrink-0" aria-hidden="true"></i>
                    <span>Jam Layanan: {{ $jamOperasional }}</span>
                </div>
            </div>

            <!-- KANAN: Form Pesan (6 Kolom) -->
            <div
                class="reveal-card opacity-0 translate-y-8 transition-all duration-700 lg:col-span-6 bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 md:p-8 shadow-xs flex flex-col justify-between">

                <div>
                    <!-- Alert Sukses Pesan Terkirim -->
                    @if (session('success'))
                        <div
                            class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm flex items-center justify-between gap-3 shadow-2xs animate-fade-in">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <i class="ti ti-circle-check text-lg"></i>
                                </div>
                                <div>
                                    <span
                                        class="font-bold block text-xs uppercase tracking-wider text-emerald-700">Berhasil!</span>
                                    <span class="text-xs sm:text-sm">{{ session('success') }}</span>
                                </div>
                            </div>
                            <button type="button" onclick="this.parentElement.remove();"
                                class="text-emerald-500 hover:text-emerald-700 p-1 cursor-pointer">
                                <i class="ti ti-x text-base"></i>
                            </button>
                        </div>
                    @endif

                    {{-- Tampilkan pesan error validasi (misal honeypot terdeteksi / karakter tidak valid) --}}
                    @if ($errors->any())
                        <div
                            class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-800 text-sm shadow-2xs">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                    <i class="ti ti-alert-circle text-lg"></i>
                                </div>
                                <div>
                                    <span class="font-bold block text-xs uppercase tracking-wider text-red-700">Gagal
                                        Mengirim</span>
                                    <span class="text-xs sm:text-sm">{{ $errors->first() }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-4">
                        @csrf

                        <div
                            class="flex items-center justify-between mb-4 sm:mb-6 pb-3 sm:pb-4 border-b border-slate-100">
                            <h3 class="font-serif text-lg sm:text-xl font-bold text-slate-900">
                                Kirim Pesan
                            </h3>

                            <!-- Toggle Switch Kirim Anonim -->
                            <label class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="checkbox" id="toggle-anonymous" name="is_anonymous" value="1"
                                    class="sr-only peer">
                                <div
                                    class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600">
                                </div>
                                <span class="ml-2 text-xs font-bold text-slate-600 uppercase">Anonim</span>
                            </label>
                        </div>

                        {{-- Honeypot Anti-Bot — jangan hapus, jangan beri type="hidden" --}}
                        <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true">
                            <label for="website">Jangan diisi kolom ini</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        <!-- Input Identitas (Disembunyikan jika mode anonim aktif) -->
                        <div id="identity-fields"
                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 transition-all duration-300">
                            <!-- Nama -->
                            <div>
                                <label for="contact-name" class="block text-xs font-semibold text-slate-700 mb-1">
                                    Nama Lengkap
                                </label>
                                <input type="text" id="contact-name" name="name" placeholder="Nama Anda"
                                    value="{{ old('name') }}" maxlength="100" pattern="^[\p{L}\s\.\-']+$"
                                    title="Nama hanya boleh berisi huruf, spasi, titik, atau strip"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50/50 border border-slate-200 focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-600 outline-none text-slate-800 text-xs sm:text-sm transition-all">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="contact-email" class="block text-xs font-semibold text-slate-700 mb-1">
                                    Alamat Email
                                </label>
                                <input type="email" id="contact-email" name="email" placeholder="nama@email.com"
                                    value="{{ old('email') }}" maxlength="150"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50/50 border border-slate-200 focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-600 outline-none text-slate-800 text-xs sm:text-sm transition-all">
                            </div>
                        </div>

                        <!-- Pesan -->
                        <div>
                            <label for="contact-message" class="block text-xs font-semibold text-slate-700 mb-1">
                                Pesan
                            </label>
                            <textarea id="contact-message" name="message" rows="5"
                                placeholder="Tuliskan pesan, saran, atau pertanyaan Anda di sini..." required minlength="5" maxlength="2000"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50/50 border border-slate-200 focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-600 outline-none text-slate-800 text-xs sm:text-sm transition-all resize-none">{{ old('message') }}</textarea>
                            <p class="mt-1 text-[10px] text-slate-400 text-right">
                                <span id="char-count">0</span>/2000 karakter
                            </p>
                        </div>

                        <!-- Tombol Kirim -->
                        <button type="submit" id="submit-btn"
                            class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition-all inline-flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                            <span>Kirim Pesan</span>
                            <i class="ti ti-send text-base" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script Scroll Reveal
            const observerOptions = {
                root: null,
                threshold: 0.15
            };
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        el.classList.remove('opacity-0', 'translate-y-8', '-translate-y-6');
                        el.classList.add('opacity-100', 'translate-y-0');
                        observer.unobserve(el);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('#kontak .reveal-item, #kontak .reveal-card').forEach(el => {
                observer.observe(el);
            });

            // Script Toggle Kirim Anonim
            const toggleAnonymous = document.getElementById('toggle-anonymous');
            const identityFields = document.getElementById('identity-fields');
            const nameInput = document.getElementById('contact-name');
            const emailInput = document.getElementById('contact-email');

            if (toggleAnonymous) {
                toggleAnonymous.addEventListener('change', function() {
                    if (this.checked) {
                        identityFields.style.opacity = '0';
                        identityFields.style.transform = 'translateY(-10px)';
                        setTimeout(() => {
                            identityFields.classList.add('hidden');
                            nameInput.value = '';
                            emailInput.value = '';
                            nameInput.removeAttribute('required');
                            emailInput.removeAttribute('required');
                        }, 200);
                    } else {
                        identityFields.classList.remove('hidden');
                        setTimeout(() => {
                            identityFields.style.opacity = '1';
                            identityFields.style.transform = 'translateY(0)';
                            nameInput.setAttribute('required', 'required');
                            emailInput.setAttribute('required', 'required');
                        }, 50);
                    }
                });
            }

            // Script Hitung Karakter Pesan
            const messageInput = document.getElementById('contact-message');
            const charCount = document.getElementById('char-count');
            if (messageInput && charCount) {
                charCount.textContent = messageInput.value.length;
                messageInput.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
            }

            // Script Cegah Submit Ganda (double-click) saat kirim pesan
            const contactForm = messageInput ? messageInput.closest('form') : null;
            const submitBtn = document.getElementById('submit-btn');
            if (contactForm && submitBtn) {
                contactForm.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    submitBtn.querySelector('span').textContent = 'Mengirim...';
                });
            }
        });
    </script>
@endpush
