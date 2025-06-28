<div class="tw-container tw-w-full tw-p-6 tw-space-y-6 tw-mx-auto">
    <!-- Header Dashboard -->
    <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6">
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
            <div>
                <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900 dark:tw-text-white tw-mb-2">Dashboard Admin</h1>
                <p class="tw-text-gray-600 dark:tw-text-gray-400">Kelola pemesanan undangan dan pantau statistik bisnis Anda</p>
            </div>
            <div class="tw-flex tw-space-x-2">
                <select class="tw-bg-gray-50 dark:tw-bg-gray-700 tw-border tw-border-gray-300 dark:tw-border-gray-600 tw-text-gray-900 dark:tw-text-white tw-text-sm tw-rounded-lg tw-px-3 tw-py-2">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>3 Bulan Terakhir</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-6">
        <!-- Total Pesanan -->
        <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6 tw-border-l-4 tw-border-blue-500">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <p class="tw-text-sm tw-font-medium tw-text-gray-600 dark:tw-text-gray-400">Total Pesanan</p>
                    <p class="tw-text-3xl tw-font-bold tw-text-gray-900 dark:tw-text-white">1,247</p>
                    <p class="tw-text-sm tw-text-green-600 tw-font-medium">+12% dari bulan lalu</p>
                </div>
                <div class="tw-w-12 tw-h-12 tw-bg-blue-100 dark:tw-bg-blue-900 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                    <svg class="tw-w-6 tw-h-6 tw-text-blue-600 dark:tw-text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6 tw-border-l-4 tw-border-green-500">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <p class="tw-text-sm tw-font-medium tw-text-gray-600 dark:tw-text-gray-400">Total Pendapatan</p>
                    <p class="tw-text-3xl tw-font-bold tw-text-gray-900 dark:tw-text-white">Rp 89.6M</p>
                    <p class="tw-text-sm tw-text-green-600 tw-font-medium">+18% dari bulan lalu</p>
                </div>
                <div class="tw-w-12 tw-h-12 tw-bg-green-100 dark:tw-bg-green-900 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                    <svg class="tw-w-6 tw-h-6 tw-text-green-600 dark:tw-text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pelanggan Aktif -->
        <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6 tw-border-l-4 tw-border-purple-500">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <p class="tw-text-sm tw-font-medium tw-text-gray-600 dark:tw-text-gray-400">Pelanggan Aktif</p>
                    <p class="tw-text-3xl tw-font-bold tw-text-gray-900 dark:tw-text-white">342</p>
                    <p class="tw-text-sm tw-text-green-600 tw-font-medium">+8% dari bulan lalu</p>
                </div>
                <div class="tw-w-12 tw-h-12 tw-bg-purple-100 dark:tw-bg-purple-900 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                    <svg class="tw-w-6 tw-h-6 tw-text-purple-600 dark:tw-text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tingkat Penyelesaian -->
        <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6 tw-border-l-4 tw-border-yellow-500">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <p class="tw-text-sm tw-font-medium tw-text-gray-600 dark:tw-text-gray-400">Tingkat Penyelesaian</p>
                    <p class="tw-text-3xl tw-font-bold tw-text-gray-900 dark:tw-text-white">94.2%</p>
                    <p class="tw-text-sm tw-text-green-600 tw-font-medium">+2.1% dari bulan lalu</p>
                </div>
                <div class="tw-w-12 tw-h-12 tw-bg-yellow-100 dark:tw-bg-yellow-900 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                    <svg class="tw-w-6 tw-h-6 tw-text-yellow-600 dark:tw-text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik dan Tabel -->
    <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-6">
        <!-- Grafik Penjualan -->
        <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6">
            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 dark:tw-text-white tw-mb-4">Grafik Penjualan 7 Hari Terakhir</h3>
            <div class="tw-h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Status Pesanan -->
        <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6">
            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 dark:tw-text-white tw-mb-4">Status Pesanan</h3>
            <div class="tw-space-y-4">
                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-bg-green-50 dark:tw-bg-green-900/20 tw-rounded-lg">
                    <div class="tw-flex tw-items-center tw-space-x-3">
                        <div class="tw-w-3 tw-h-3 tw-bg-green-500 tw-rounded-full"></div>
                        <span class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Selesai</span>
                    </div>
                    <span class="tw-text-sm tw-font-bold tw-text-green-600">672</span>
                </div>
                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-bg-yellow-50 dark:tw-bg-yellow-900/20 tw-rounded-lg">
                    <div class="tw-flex tw-items-center tw-space-x-3">
                        <div class="tw-w-3 tw-h-3 tw-bg-yellow-500 tw-rounded-full"></div>
                        <span class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Dalam Proses</span>
                    </div>
                    <span class="tw-text-sm tw-font-bold tw-text-yellow-600">284</span>
                </div>
                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-bg-blue-50 dark:tw-bg-blue-900/20 tw-rounded-lg">
                    <div class="tw-flex tw-items-center tw-space-x-3">
                        <div class="tw-w-3 tw-h-3 tw-bg-blue-500 tw-rounded-full"></div>
                        <span class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Menunggu Konfirmasi</span>
                    </div>
                    <span class="tw-text-sm tw-font-bold tw-text-blue-600">156</span>
                </div>
                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-bg-red-50 dark:tw-bg-red-900/20 tw-rounded-lg">
                    <div class="tw-flex tw-items-center tw-space-x-3">
                        <div class="tw-w-3 tw-h-3 tw-bg-red-500 tw-rounded-full"></div>
                        <span class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Dibatalkan</span>
                    </div>
                    <span class="tw-text-sm tw-font-bold tw-text-red-600">42</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Terbaru -->
    <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6">
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 dark:tw-text-white">Pesanan Terbaru</h3>
            <button class="tw-px-4 tw-py-2 tw-bg-blue-600 tw-text-white tw-text-sm tw-rounded-lg hover:tw-bg-blue-700 tw-transition-colors">
                Lihat Semua
            </button>
        </div>
        <div class="tw-overflow-x-auto">
            <table class="tw-w-full tw-text-sm tw-text-left">
                <thead class="tw-text-xs tw-text-gray-700 dark:tw-text-gray-400 tw-uppercase tw-bg-gray-50 dark:tw-bg-gray-700">
                    <tr>
                        <th class="tw-px-6 tw-py-3">ID Pesanan</th>
                        <th class="tw-px-6 tw-py-3">Pelanggan</th>
                        <th class="tw-px-6 tw-py-3">Jenis Undangan</th>
                        <th class="tw-px-6 tw-py-3">Status</th>
                        <th class="tw-px-6 tw-py-3">Total</th>
                        <th class="tw-px-6 tw-py-3">Tanggal</th>
                        <th class="tw-px-6 tw-py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="tw-bg-white dark:tw-bg-gray-800 tw-divide-y tw-divide-gray-200 dark:tw-divide-gray-700">
                    <tr class="hover:tw-bg-gray-50 dark:hover:tw-bg-gray-700">
                        <td class="tw-px-6 tw-py-4 tw-font-medium tw-text-gray-900 dark:tw-text-white">#INV001</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Budi Santoso</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Undangan Pernikahan</td>
                        <td class="tw-px-6 tw-py-4">
                            <span class="tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-rounded-full tw-bg-yellow-100 tw-text-yellow-800 dark:tw-bg-yellow-900 dark:tw-text-yellow-300">
                                Dalam Proses
                            </span>
                        </td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Rp 850.000</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">28 Jun 2025</td>
                        <td class="tw-px-6 tw-py-4">
                            <button class="tw-text-blue-600 hover:tw-text-blue-800 tw-font-medium">Detail</button>
                        </td>
                    </tr>
                    <tr class="hover:tw-bg-gray-50 dark:hover:tw-bg-gray-700">
                        <td class="tw-px-6 tw-py-4 tw-font-medium tw-text-gray-900 dark:tw-text-white">#INV002</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Sari Dewi</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Undangan Ulang Tahun</td>
                        <td class="tw-px-6 tw-py-4">
                            <span class="tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-rounded-full tw-bg-green-100 tw-text-green-800 dark:tw-bg-green-900 dark:tw-text-green-300">
                                Selesai
                            </span>
                        </td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Rp 450.000</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">27 Jun 2025</td>
                        <td class="tw-px-6 tw-py-4">
                            <button class="tw-text-blue-600 hover:tw-text-blue-800 tw-font-medium">Detail</button>
                        </td>
                    </tr>
                    <tr class="hover:tw-bg-gray-50 dark:hover:tw-bg-gray-700">
                        <td class="tw-px-6 tw-py-4 tw-font-medium tw-text-gray-900 dark:tw-text-white">#INV003</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Ahmad Rahman</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Undangan Khitanan</td>
                        <td class="tw-px-6 tw-py-4">
                            <span class="tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-rounded-full tw-bg-blue-100 tw-text-blue-800 dark:tw-bg-blue-900 dark:tw-text-blue-300">
                                Menunggu Konfirmasi
                            </span>
                        </td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Rp 675.000</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">26 Jun 2025</td>
                        <td class="tw-px-6 tw-py-4">
                            <button class="tw-text-blue-600 hover:tw-text-blue-800 tw-font-medium">Detail</button>
                        </td>
                    </tr>
                    <tr class="hover:tw-bg-gray-50 dark:hover:tw-bg-gray-700">
                        <td class="tw-px-6 tw-py-4 tw-font-medium tw-text-gray-900 dark:tw-text-white">#INV004</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Linda Maharani</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Undangan Graduation</td>
                        <td class="tw-px-6 tw-py-4">
                            <span class="tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-rounded-full tw-bg-green-100 tw-text-green-800 dark:tw-bg-green-900 dark:tw-text-green-300">
                                Selesai
                            </span>
                        </td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">Rp 325.000</td>
                        <td class="tw-px-6 tw-py-4 tw-text-gray-900 dark:tw-text-white">25 Jun 2025</td>
                        <td class="tw-px-6 tw-py-4">
                            <button class="tw-text-blue-600 hover:tw-text-blue-800 tw-font-medium">Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Jenis Undangan Populer -->
    <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-6">
        <!-- Top Products -->
        <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6">
            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 dark:tw-text-white tw-mb-4">Jenis Undangan Populer</h3>
            <div class="tw-space-y-4">
                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-border tw-border-gray-200 dark:tw-border-gray-700 tw-rounded-lg">
                    <div class="tw-flex tw-items-center tw-space-x-3">
                        <div class="tw-w-10 tw-h-10 tw-bg-pink-100 dark:tw-bg-pink-900 tw-rounded-lg tw-flex tw-items-center tw-justify-center">
                            <svg class="tw-w-5 tw-h-5 tw-text-pink-600 dark:tw-text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Undangan Pernikahan</p>
                            <p class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400">487 pesanan</p>
                        </div>
                    </div>
                    <span class="tw-text-sm tw-font-bold tw-text-gray-900 dark:tw-text-white">39%</span>
                </div>
                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-border tw-border-gray-200 dark:tw-border-gray-700 tw-rounded-lg">
                    <div class="tw-flex tw-items-center tw-space-x-3">
                        <div class="tw-w-10 tw-h-10 tw-bg-blue-100 dark:tw-bg-blue-900 tw-rounded-lg tw-flex tw-items-center tw-justify-center">
                            <svg class="tw-w-5 tw-h-5 tw-text-blue-600 dark:tw-text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Undangan Ulang Tahun</p>
                            <p class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400">298 pesanan</p>
                        </div>
                    </div>
                    <span class="tw-text-sm tw-font-bold tw-text-gray-900 dark:tw-text-white">24%</span>
                </div>
                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-border tw-border-gray-200 dark:tw-border-gray-700 tw-rounded-lg">
                    <div class="tw-flex tw-items-center tw-space-x-3">
                        <div class="tw-w-10 tw-h-10 tw-bg-green-100 dark:tw-bg-green-900 tw-rounded-lg tw-flex tw-items-center tw-justify-center">
                            <svg class="tw-w-5 tw-h-5 tw-text-green-600 dark:tw-text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Undangan Khitanan</p>
                            <p class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400">187 pesanan</p>
                        </div>
                    </div>
                    <span class="tw-text-sm tw-font-bold tw-text-gray-900 dark:tw-text-white">15%</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6">
            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 dark:tw-text-white tw-mb-4">Aktivitas Terbaru</h3>
            <div class="tw-space-y-4">
                <div class="tw-flex tw-items-center tw-space-x-3">
                    <div class="tw-w-8 tw-h-8 tw-bg-blue-100 dark:tw-bg-blue-900 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                        <svg class="tw-w-4 tw-h-4 tw-text-blue-600 dark:tw-text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Pelanggan baru mendaftar</p>
                        <p class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400">5 menit yang lalu</p>
                    </div>
                </div>

                <div class="tw-flex tw-items-center tw-space-x-3">
                    <div class="tw-w-8 tw-h-8 tw-bg-yellow-100 dark:tw-bg-yellow-900 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                        <svg class="tw-w-4 tw-h-4 tw-text-yellow-600 dark:tw-text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Pesanan #INV001 menunggu konfirmasi</p>
                        <p class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400">10 menit yang lalu</p>
                    </div>
                </div>

                <div class="tw-flex tw-items-center tw-space-x-3">
                    <div class="tw-w-8 tw-h-8 tw-bg-purple-100 dark:tw-bg-purple-900 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                        <svg class="tw-w-4 tw-h-4 tw-text-purple-600 dark:tw-text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Pembayaran #INV003 diterima</p>
                        <p class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400">15 menit yang lalu</p>
                    </div>
                </div>

                <div class="tw-flex tw-items-center tw-space-x-3">
                    <div class="tw-w-8 tw-h-8 tw-bg-red-100 dark:tw-bg-red-900 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                        <svg class="tw-w-4 tw-h-4 tw-text-red-600 dark:tw-text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-white">Pesanan #INV005 dibatalkan</p>
                        <p class="tw-text-xs tw-text-gray-500 dark:tw-text-gray-400">1 jam yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>