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
    <link rel="stylesheet" href="{{ asset('build/assets/app-CrJ1lieA.css') }}">
    <script src="{{ asset('build/assets/app-BQ20r_nR.js') }}" defer></script>
    
    <!-- Livewire Styles -->
    @livewireStyles
    <style>
  
    /* Toast Horizontal Layout Styles */
.toast-popup-pro {
    /* Mengatur lebar otomatis dengan batas maksimal */
    width: auto !important;
    max-width: 90vw !important;
    min-width: 300px !important;
    
    /* Mencegah text wrap dan memaksa satu baris */
    white-space: nowrap !important;
    
    /* Shadow untuk depth */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
}


</style>

</head>

<body class="font-sans bg-light text-dark">
    <div class="d-flex min-vh-100">
        <!-- Sidebar Component -->
        <livewire:layouts.admin.sidebar />
        <!-- Main Content Area -->
        <main class="flex-grow-1 py-4 px-3 overflow-auto" style="min-height: 100vh;">
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
            Livewire.on("toast:eror", (message) => {
                Toast.fire({
                    icon: "eror",
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
            Livewire.on('userUpdated', () => {
                $('#editModal').modal('hide');
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('userDeleted', () => {
                $('#deleteModal').modal('hide');
            });
        });
        //user-table-end

        //produks-table
        document.addEventListener('livewire:init', () => {
            Livewire.on('produksUpdated', () => {
                $('#editModal').modal('hide');
            });
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('produksCreated', () => {
                $('#createModal').modal('hide');
            });
        });
    </script>


</body>

</html>
