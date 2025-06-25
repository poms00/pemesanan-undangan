<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

   
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS (via CDN or install via npm) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
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
   
</head>

<body class="bg-gray-50 dark:bg-gray-900">

    <!-- Navigation -->
    @livewire('layouts.user.navbar')

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>


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
            Livewire.on("toast:error", (message) => {
                Toast.fire({
                    icon: "error",
                    title: message,
                });
            });
        });

        //masukan keranjang
        document.addEventListener('livewire:init', () => {
            Livewire.on('KeranjangModal', () => {
                $('#createPemesananModal').modal('hide');
            });
        });

    </script>

    

    
</body>

</html>
