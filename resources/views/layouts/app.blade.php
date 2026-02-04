<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Cek apakah ada session SUCCESS dari Controller
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000, // Otomatis tutup dalam 2 detik
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    background: '#fff',
                    iconColor: '#10B981', // Warna hijau emerald
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
            @endif

            // Cek apakah ada session ERROR
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    iconColor: '#EF4444', // Warna merah
                });
            @endif

            // Cek apakah ada ERROR VALIDASI (misal input kosong)
            @if($errors->any())
                Swal.fire({
                    icon: 'warning',
                    title: 'Periksa Inputan',
                    html: '<ul class="text-left">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                    confirmButtonText: 'Oke, Saya Perbaiki',
                    confirmButtonColor: '#4F46E5', // Warna indigo
                });
            @endif
        </script>

    </body>
</html>
