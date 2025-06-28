<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">



        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            <!-- Informasi Pemesan & Undangan -->
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-white rounded-lg shadow">
                    <!-- Kontainer Detail Undangan -->
                    <div id="step-1" style="min-height: 560px;">
                        <div style="padding: 1.7rem 1.25rem; border-bottom: 1px solid #E5E7EB;">
                            <h2
                                style="font-size: 1.125rem; font-weight: 600; color: #1F2937; display: flex; align-items: center; margin: 0;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #DB2777; margin-right: 0.5rem;"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd" />
                                </svg>
                                Detail Undangan
                            </h2>
                        </div>

                        <!-- Form Container -->
                        <div class="card-body p-4">
                            <!-- Step 1: Data Pemesanan -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nama Mempelai Pria -->
                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Mempelai Pria <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" wire:model.live="nama_mempelai_pria"
                                        placeholder="Masukkan nama mempelai pria"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_mempelai_pria') border-red-500 @enderror">
                                    @error('nama_mempelai_pria')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nama Mempelai Wanita -->
                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Mempelai Wanita <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" wire:model.live="nama_mempelai_wanita"
                                        placeholder="Masukkan nama mempelai wanita"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_mempelai_wanita') border-red-500 @enderror">
                                    @error('nama_mempelai_wanita')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Acara -->
                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Acara <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" wire:model.live="tanggal_acara"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_acara') border-red-500 @enderror">
                                    @error('tanggal_acara')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jumlah Tamu -->
                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah Tamu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" wire:model.live="jumlah_tamu"
                                        placeholder="Masukkan jumlah tamu" min="1" max="10000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jumlah_tamu') border-red-500 @enderror">
                                    @error('jumlah_tamu')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Lokasi Pernikahan -->
                                <div class="form-group md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Lokasi Acara <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" wire:model.live="lokasi"
                                        placeholder="Masukkan lokasi acara pernikahan"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('lokasi') border-red-500 @enderror">
                                    @error('lokasi')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nomor WhatsApp -->
                                <div class="form-group md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        No. WhatsApp Aktif <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" wire:model.live="nomor_telepon"
                                        placeholder="Contoh: 081234567890"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nomor_telepon') border-red-500 @enderror">
                                    <p class="text-gray-500 text-xs mt-1">Format: 08xxxxxxxxxx atau +628xxxxxxxxxx</p>
                                    @error('nomor_telepon')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>


                            </div>
                        </div>
                    </div>


                    <div id="step-2" style="display: none; min-height: 560px;">
                        <!-- Snap Embed -->
                        <div id="snap-container" style="width: 100%;" wire:ignore.self></div>
                    </div>
                </div>
            </div>



            <!-- Ringkasan Pembayaran -->
            <div class="lg:col-span-2 flex flex-col h-full">
                <!-- Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col h-full">

                    <!-- Header -->
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Order Summary</h2>
                    </div>

                    <!-- Produk -->
                    <div class="bg-gray-50 rounded-lg  p-2 mb-4">
                        <div class="flex justify-between items-start space-x-4">
                            <!-- Gambar Produk -->
                            <div class="flex items-center space-x-4">
                                @if ($produk->thumbnail)
                                    <img src="{{ asset('storage/' . $produk->thumbnail) }}" alt="{{ $produk->nama }}"
                                        class="w-20 h-20 rounded-lg object-cover border border-gray-200" />
                                @else
                                    <div class="w-20 h-20 flex items-center justify-center rounded-lg border border-gray-200 bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="16" rx="2"
                                                ry="2" />
                                            <circle cx="8.5" cy="10.5" r="1.5" />
                                            <polyline points="21 15 16 10 5 21" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Info Produk -->
                                <div class="flex flex-col justify-center leading-tight space-y-2">
                                    <div class="text-base font-semibold text-gray-800">
                                        {{ $produk->nama ?? '-' }}
                                    </div>
                                    <div class="inline-flex items-center space-x-2 text-gray-600 text-sm">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 4a1 1 0 011-1h3.28a1 1 0 01.948.684L9.382 5H20a1 1 0 01.894 1.447l-3 6A1 1 0 0117 13H7a1 1 0 01-.894-.553L3.382 5.447A1 1 0 013 5V4z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 16a2 2 0 100 4 2 2 0 000-4zm12 0a2 2 0 100 4 2 2 0 000-4z" />
                                        </svg>
                                        <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-md">
                                            {{ $produk->kategori?->nama_kategori ?? 'Kategori tidak tersedia' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="flex flex-col text-right">
                                @if ($produk->diskon && $produk->diskon > 0)
                                    @php
                                        $hargaDiskon = $produk->harga - ($produk->harga * $produk->diskon) / 100;
                                    @endphp
                                    <span class="text-sm text-gray-500 line-through">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-lg font-bold text-green-600">
                                        Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-lg font-bold text-gray-800">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Rincian Harga -->
                    <div class="bg-gray-50 p-3 rounded-md space-y-3 text-sm text-gray-800 mb-6">
                        <div class="flex justify-between">
                            <span>Harga asli</span>
                            <span class="text-gray-600 font-medium whitespace-nowrap">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Diskon</span>
                            <span class="text-gray-600 font-medium whitespace-nowrap">
                                ({{ $produk->diskon }}%) Rp
                                {{ number_format(($produk->harga * $produk->diskon) / 100, 0, ',', '.') }}
                            </span>
                        </div>
                        <hr class="border-gray-300" />
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total</span>
                            <span class="text-gray-800">
                                Rp {{ number_format($checkout['harga'] ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-auto pt-4 border-t">
                       
                        <button type="button"
                        onclick="nextStep()" {{-- biar JS jalan --}}
                        wire:loading.attr="disabled"
                        wire:target="buatpemesanan"
                        class="btn btn-primary px-4 w-full text-white font-semibold py-2.5 rounded-lg transition duration-200 hover:bg-blue-700"
                        style="background: linear-gradient(45deg, #007bff, #0056b3); border: none;">
                    
                        <!-- Saat tidak loading -->
                        <span wire:loading.remove wire:target="submitpemesanan">
                            <i class="fas fa-credit-card me-2"></i> Bayar Sekarang
                        </span>
                    
                        <!-- Saat loading -->
                        <span wire:loading wire:target="submitpemesanan">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Menunggu Pembayaran...
                        </span>
                    </button>
                    
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}"></script>


<!-- Load Snap JS dari Midtrans -->
<!-- Token Snap dari Laravel Session -->
<script>
    const snapToken = {!! json_encode(session('checkout.snap_token')) !!};
    let currentStep = 1;
    let snapLoaded = false;

    function nextStep() {
        if (currentStep < 2) {
            document.getElementById('step-' + currentStep).style.display = 'none';
            currentStep++;
            document.getElementById('step-' + currentStep).style.display = 'block';

            if (currentStep === 2) {
                loadMidtransSnap();
            }
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            if (currentStep === 2) {
                resetSnapContainer();
                snapLoaded = false;
            }
            document.getElementById('step-' + currentStep).style.display = 'none';
            currentStep--;
            document.getElementById('step-' + currentStep).style.display = 'block';
        }
    }

    function loadMidtransSnap() {
        if (!snapToken) {
            console.error('Snap token is not available');
            showSnapError('Token pembayaran tidak tersedia');
            return;
        }

        if (snapLoaded) {
            console.log('Snap already loaded');
            return;
        }

        if (typeof snap === 'undefined') {
            console.error('Snap is not defined. Pastikan snap.js sudah dimuat.');
            showSnapError('Gateway pembayaran belum siap');
            return;
        }

        try {
            snap.embed(snapToken, {
                embedId: 'snap-container',
                onSuccess: handlePaymentSuccess,
                onPending: handlePaymentPending,
                onError: handlePaymentError,
                onClose: function() {
                    console.log('Payment popup closed');
                }
            });

            snapLoaded = true;
        } catch (error) {
            console.error('Error loading Midtrans Snap:', error);
            showSnapError('Gagal memuat gateway pembayaran');
        }
    }

    function handlePaymentSuccess(result) {
        console.log('Payment Success:', result);
        //showSnapSuccess(result);

        // ✅ Kirim data ke Livewire
        window.dispatchEvent(new CustomEvent('submitpemesanan', {
            detail: result
        }));
    }

    function handlePaymentPending(result) {
        console.log('Payment Pending:', result);
        showSnapPending(result);

        // ✅ Kirim data ke Livewire
        window.dispatchEvent(new CustomEvent('submitpemesanan', {
            detail: result
        }));
    }

    function handlePaymentError(result) {
        console.error('Payment Error:', result);
        showSnapError('Pembayaran gagal: ' + (result.status_message || 'Silakan coba lagi'));
    }

    function showSnapSuccess(result) {
        const snapContainer = document.getElementById('snap-container');
        snapContainer.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-check-circle text-green-500" style="font-size: 64px; margin-bottom: 20px;"></i>
                <h4 class="text-green-600 mb-3">Pembayaran Berhasil!</h4>
                <p class="text-muted mb-4">Terima kasih, pembayaran Anda telah berhasil diproses.</p>
                <div class="alert alert-success">
                    <strong>Order ID:</strong> ${result.order_id}<br>
                    <strong>Transaction ID:</strong> ${result.transaction_id}
                </div>
            </div>
        `;
    }

    function showSnapPending(result) {
        const snapContainer = document.getElementById('snap-container');
        snapContainer.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-clock text-yellow-500" style="font-size: 64px; margin-bottom: 20px;"></i>
                <h4 class="text-yellow-600 mb-3">Pembayaran Tertunda</h4>
                <p class="text-muted mb-4">Pembayaran Anda sedang diproses.</p>
                <div class="alert alert-warning">
                    <strong>Order ID:</strong> ${result.order_id}
                </div>
            </div>
        `;
    }

    function showSnapError(message) {
        const snapContainer = document.getElementById('snap-container');
        snapContainer.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-exclamation-triangle text-red-500" style="font-size: 64px; margin-bottom: 20px;"></i>
                <h5 class="text-red-600 mb-3">Error</h5>
                <p class="text-muted mb-4">${message}</p>
                <button class="btn btn-primary" onclick="retryLoadSnap()">Coba Lagi</button>
            </div>
        `;
    }

    function resetSnapContainer() {
        const snapContainer = document.getElementById('snap-container');
        if (snapContainer) {
            snapContainer.innerHTML = '';
        }
    }

    function retryLoadSnap() {
        resetSnapContainer();
        snapLoaded = false;
        loadMidtransSnap();
    }
</script>

