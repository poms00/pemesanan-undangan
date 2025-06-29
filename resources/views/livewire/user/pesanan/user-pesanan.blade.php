<div class="tw-container tw-w-5xl tw-p-6 tw-space-y-6  tw-mx-auto">
    <!-- Header -->
    <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6">
        <h1 class="tw-text-2xl tw-font-bold tw-text-gray-900 dark:tw-text-white tw-mb-2">Informasi Pemesanan</h1>
        <p class="tw-text-gray-600 dark:tw-text-gray-400">Berikut adalah riwayat dan status pesanan Anda yang terbaru.
        </p>
    </div>

    <!-- Orders List -->
    <div class="tw-space-y-4">
        @forelse($pesanans as $pesanan)
            <div
                style="display: flex; align-items: center; background-color: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 16px; gap: 16px; transition: box-shadow 0.2s ease; position: relative;">
                <!-- Thumbnail -->
                <div
                    style="width: 80px; height: 80px; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                    @if ($pesanan->produk->thumbnail)
                        <img src="{{ asset('storage/' . $produk->thumbnail) }}" alt="{{ $produk->nama }}"
                            class="w-20 h-20 rounded-lg object-cover border border-gray-200" />
                    @else
                        <div
                            class="w-20 h-20 flex items-center justify-center rounded-lg border border-gray-200 bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="16" rx="2" ry="2" />
                                <circle cx="8.5" cy="10.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div style="flex: 1; display: flex; flex-direction: column; gap: 4px;">
                    <h2 style="font-size: 18px; font-weight: 600; color: #1f2937; margin: 0;">
                        {{ $pesanan->nama_template }}
                    </h2>
                    <div style="display: inline-flex; align-items: center; gap: 2px; background-color:#e6f1ff; color: #1e40af;    font-size: 12px; font-weight: 600; padding: 4px 8px; border-radius: 9999px; width: fit-content;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                        </svg>
                        
                        <span>{{ $pesanan->produk->kategori->nama_kategori ?? 'Tanpa Kategori' }}</span>
                    </div>

                    <p style="font-size: 12px; color: #6b7280; margin: 0;">Tanggal Pesanan:
                        {{ $pesanan->created_at->translatedFormat('d F Y') }}</p>
                </div>

                <!-- Order Details -->
                <div
                    style="display: flex; flex-direction: column; align-items: flex-end; justify-content: center; min-width: 120px; gap: 4px;">
                    <p style="font-size: 14px; font-family: monospace; color: #374151; margin: 0;">
                        {{ $pesanan->transaksi->order_id ?? '-' }}
                    </p>
                    <p style="font-weight: 600; color: #16a34a; font-size: 14px; display: flex; align-items: center; gap: 4px; margin: 0;">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        {{ ucfirst($pesanan->status_pemesanan) }}
                    </p>
                    
                    @if ($pesanan->transaksi && $pesanan->transaksi->settlement_time)
                        <p style="font-size: 11px; color: #6b7280; margin: 0;">
                            Pembayaran-dikonfirmasi {{ \Carbon\Carbon::parse($pesanan->transaksi->settlement_time)->timezone('Asia/Jakarta')->diffForHumans() }}
                        </p>
                    @endif
                </div>

                <!-- Menu Button -->
                <div style="display: flex; align-items: center; margin-left: 8px;">
                    <button type="button"
                        style="color: #9ca3af; background: none; border: none; cursor: pointer; padding: 8px; border-radius: 6px; transition: all 0.15s ease; display: flex; align-items: center; justify-content: center;"
                        onmouseover="this.style.color='#6b7280'; this.style.backgroundColor='#f3f4f6';"
                        onmouseout="this.style.color='#9ca3af'; this.style.backgroundColor='transparent';">
                        <svg style="width: 18px; height: 18px;" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="5" r="1.5" />
                            <circle cx="12" cy="12" r="1.5" />
                            <circle cx="12" cy="19" r="1.5" />
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="tw-text-center tw-text-gray-500 tw-text-sm">Belum ada pesanan.</div>
        @endforelse
    </div>

</div>
