<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS (via CDN or install via npm) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles
    <style>
        /* Toast Horizontal Layout Styles */

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #9ca3af transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #9ca3af;
            /* Tailwind gray-400 */
            border-radius: 4px;
        }
    </style>

</head>

<body class="font-sans bg-light text-dark">
    <div class="d-flex vh-100 overflow-hidden">
        <!-- Sidebar Component - Fixed -->
        <div class="flex-shrink-0">
            <livewire:layouts.admin.sidebar />
        </div>

        <!-- Main Content Area - Scrollable -->
        <main class="flex-grow-1  px-3 overflow-scroll mt-20 custom-scrollbar">
            {{ $slot }}
        </main>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
    <script>
        //toast
        if (!window.Toast) {
            window.Toast = Swal.mixin({
                toast: true,
                position: "top",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: "toast-popup-pro",
                    title: "toast-title-pro",
                    icon: "toast-icon-pro",
                    timerProgressBar: "toast-progress-pro",
                    closeButton: "toast-closebtn-pro",
                },

                didOpen: (toast) => {
                    const closeBtn = toast.querySelector(".toast-closebtn-pro");
                    if (closeBtn) {
                        closeBtn.addEventListener("click", () => {
                            Swal.close();
                        });
                    }
                },
                showCloseButton: true,
                closeButtonHtml: `<button class="toast-closebtn-pro" aria-label="Close">&times;</button>`,
            });
        }


        document.addEventListener("DOMContentLoaded", () => {
            Livewire.on("toast:success", (message) => {
                Toast.fire({
                    icon: "success",
                    title: message,
                });
            });
        });
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.on("toast:info", (message) => {
                Toast.fire({
                    icon: "info",
                    title: message,
                });
            });
        });
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.on("toast:error", (message) => { // ← DIPERBAIKI: "error"
                Toast.fire({
                    icon: "error", // ← DIPERBAIKI: "error"
                    title: message,
                });
            });
        });

        //user-table
        document.addEventListener('livewire:init', () => {
            Livewire.on('userCreated', () => {
                $('#createModal').modal('hide');
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('EdituserModal', () => {
                $('#editModal').modal('show'); // buka modal secara manual
            });

            Livewire.on('userUpdated', () => {
                $('#editModal').modal('hide');
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('openDeleteModal', () => {
                $('#deleteModal').modal('show'); // buka modal secara manual
            });

            Livewire.on('userDeleted', () => {
                $('#deleteModal').modal('hide');
            });
        });
        //user-table-end

        //produks-table
        document.addEventListener('livewire:init', () => {
            Livewire.on('produksCreated', () => {
                $('#createModal').modal('hide');
            });
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('EditprodukModal', () => {
                $('#editModal').modal('show'); // buka modal secara manual
            });

            Livewire.on('produksUpdated', () => {
                $('#editModal').modal('hide');
            });
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('openDeleteModal', () => {
                $('#deleteModal').modal('show'); // buka modal secara manual
            });

            Livewire.on('produkDeleted', () => {
                $('#deleteModal').modal('hide'); // tutup modal setelah delete
            });
        });
        
        //Kategori-template
        document.addEventListener('livewire:init', () => {
            Livewire.on('kategoriCreated', () => {
                $('#createModal').modal('hide');
            });
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('EditKategoriModal', () => {
                $('#editModal').modal('show'); // buka modal secara manual
            });

            Livewire.on('kategoriUpdated', () => {
                $('#editModal').modal('hide');
            });
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('openDeleteModal', () => {
                $('#deleteModal').modal('show'); // buka modal secara manual
            });

            Livewire.on('kategoriDeleted', () => {
                $('#deleteModal').modal('hide'); // tutup modal setelah delete
            });
        });
    </script>


</body>

</html>
