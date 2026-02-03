<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Leman Barokah') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-900 via-indigo-700 to-sky-500 relative overflow-hidden">

            <div class="absolute top-0 left-0 -mt-20 -ml-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-20 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-4000"></div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/90 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-3xl z-10 border border-white/40 relative">
                
                <div class="flex justify-center mb-6">
                    <a href="/" class="transition transform hover:scale-110">
                        <div class="bg-gradient-to-tr from-blue-600 to-cyan-500 text-white p-4 rounded-2xl shadow-lg shadow-blue-500/30">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </a>
                </div>

                <h2 class="text-center text-3xl font-extrabold text-gray-800 mb-2 tracking-tight">Leman Barokah</h2>
                <p class="text-center text-gray-500 font-medium mb-8">Login untuk memesan makanan</p>

                <div class="space-y-6">
                    {{ $slot }}
                </div>
            </div>

            <div class="z-10 mt-8 text-white/80 text-sm font-medium drop-shadow-md">
                &copy; {{ date('Y') }} Leman Barokah Resto.
            </div>
        </div>
    </body>
</html>