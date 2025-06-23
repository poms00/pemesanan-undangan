<div class="tw-container tw-w-full tw-p-6 tw-space-y-6  tw-mx-auto">
    <!-- Header -->
    <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6">
        <h1 class="tw-text-2xl tw-font-bold tw-text-gray-900 dark:tw-text-white tw-mb-2">Welcome Back!</h1>
        <p class="tw-text-gray-600 dark:tw-text-gray-400">You're logged in! This is your dashboard where you
            can manage your application.</p>
    </div>

    <!-- Recent Activity -->
    <div>
        {{-- Search Bar --}}
        <div class="mb-6">
            <div style="display: flex; gap: 0.75rem; align-items: center;">
                <div style="position: relative; flex: 1;">
                    <input type="text" placeholder="Search..."
                        style="width: 100%; padding: 0.5rem 2rem 0.5rem 2rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; background: white; font-size: 0.8rem; font-weight: 400; letter-spacing: 0.02em; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); outline: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"
                        onFocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1), 0 5px 12px rgba(59, 130, 246, 0.1)'; this.style.transform='translateY(-1px)'"
                        onBlur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.05)'; this.style.transform='translateY(0)'"
                        onInput="toggleClearButton(this)" wire:model.live="search" />

                    @if ($search)
                        <button
                            style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border: none; color: #64748b; cursor: pointer; padding: 0.25rem; border-radius: 0.75rem; transition: all 0.2s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                            onMouseEnter="this.style.background='linear-gradient(135deg, #e2e8f0, #cbd5e1)'; this.style.color='#475569'; this.style.transform='translateY(-50%) scale(1.05)'"
                            onMouseLeave="this.style.background='linear-gradient(135deg, #f1f5f9, #e2e8f0)'; this.style.color='#64748b'; this.style.transform='translateY(-50%) scale(1)'"
                            wire:click="$set('search', '')">
                            <svg style="width: 0.75rem; height: 0.75rem;" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                    @endif

                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Filter Button --}}
                <button type="button"
                    style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; border: none; border-radius: 0.75rem; font-size: 0.8rem; font-weight: 500; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3); display: flex; align-items: center; gap: 0.5rem; min-width: fit-content;"
                    onMouseEnter="this.style.background='linear-gradient(135deg, #2563eb, #1e40af)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(59, 130, 246, 0.4)'"
                    onMouseLeave="this.style.background='linear-gradient(135deg, #3b82f6, #1d4ed8)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(59, 130, 246, 0.3)'"
                    wire:click="toggleFilter()">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z">
                        </path>
                    </svg>
                    Filter
                </button>
            </div>
        </div>

        {{-- Product Cards Grid --}}
        @if ($produks->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
                @foreach ($produks as $produk)
                    @if ($produk->status === 'aktif')
                        <div
                            class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
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
                                    <div
                                        class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
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
                                            {{-- Discounted Price --}}
                                            @php
                                                $hargaDiskon =
                                                    $produk->harga - ($produk->harga * $produk->diskon) / 100;
                                            @endphp
                                            <span class="text-lg font-bold text-green-600">
                                                Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                                            </span>
                                            <span class="text-sm text-gray-500 line-through">
                                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                            </span>
                                        @else
                                            {{-- Regular Price --}}
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

                                        <button type="button" class="btn btn-primary" wire:click.prevent="pilihProduk({{ $produk->id }})"
                                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                            Pesan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba ubah kata kunci pencarian Anda.</p>
            </div>
        @endif
    </div>

</div>
