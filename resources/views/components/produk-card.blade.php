@props(['produk'])

@if ($produk->status === 'aktif')
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        {{-- Product Image --}}
        <div class="relative">
            @if ($produk->thumbnail)
                <img src="{{ asset('storage/' . $produk->thumbnail) }}" alt="{{ $produk->nama }}"
                    class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            @endif

            {{-- Discount Badge --}}
            @if ($produk->diskon && $produk->diskon > 0)
                <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                    -{{ $produk->diskon }}%
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="p-4">
            {{-- Product Name --}}
            <h3 class="font-semibold text-lg text-gray-800 mb-2 line-clamp-2">
                {{ $produk->nama }}
            </h3>

            {{-- Category --}}
            <div class="mb-3">
                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                    {{ $produk->kategori->nama_kategori }}
                </span>
            </div>

            {{-- Price Section --}}
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    @if ($produk->diskon && $produk->diskon > 0)
                        @php
                            $hargaDiskon = $produk->harga - ($produk->harga * $produk->diskon) / 100;
                        @endphp
                        <span class="text-lg font-bold text-green-600">
                            Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-gray-500 line-through">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                    @else
                        <span class="text-lg font-bold text-gray-800">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    <button
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200">
                        Preview
                    </button>
                    <button type="button" wire:click.prevent="pilihProduk({{ $produk->id }})"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200">
                        Pesan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
