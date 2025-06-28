<div class="tw-container tw-w-5xl tw-p-6 tw-space-y-6  tw-mx-auto">
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
                <div x-data="{ open: false }" class="relative inline-block">
                    <button type="button" @click="open = !open"
                        class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-xl text-sm font-medium shadow-md flex items-center gap-2 transition duration-300 hover:from-blue-600 hover:to-blue-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z" />
                        </svg>
                        Kategori
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute top-0 right-full mr-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                        <ul class="p-2 text-sm text-gray-700 w-max">

                            {{-- Opsi Semua --}}
                            <li>
                                <button wire:click="setFilterKategori('all')"
                                    class="block w-full px-2 py-2 text-left hover:bg-gray-100 transition whitespace-nowrap">
                                    Semua Kategori
                                </button>
                            </li>

                            {{-- Looping kategori dari database --}}
                            @forelse ($kategoriList as $kategori)
                                <li>
                                    <button wire:click="setFilterKategori('{{ $kategori->id }}')"
                                        class="block w-full px-2 py-2 text-left hover:bg-gray-100 transition whitespace-nowrap">
                                        {{ $kategori->nama_kategori }}
                                    </button>
                                </li>
                            @empty
                                <li>
                                    <span class="block w-full px-2 py-2 text-left text-sm text-gray-500">
                                        Tidak ada kategori
                                    </span>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                </div>




            </div>
        </div>

        {{-- Product Cards Grid --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($produkList as $produk)
                <x-produk-card :produk="$produk" />
            @empty
                <div class="col-span-full text-center text-gray-500">Belum ada produk untuk kategori ini.</div>
            @endforelse
        </div>

    </div>

</div>
