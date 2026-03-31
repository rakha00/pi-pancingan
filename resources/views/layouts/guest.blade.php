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
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased bg-gray-50 dark:bg-gray-900 relative">
        <!-- Background decoration -->
        <div class="absolute top-0 inset-x-0 h-40 bg-indigo-600 dark:bg-indigo-900/40 opacity-10 blur-3xl -z-10"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500 dark:bg-blue-800/20 opacity-10 rounded-full blur-3xl -z-10"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center py-12 sm:py-20 px-4">
            <div class="mb-6">
                <a href="/">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-32 h-auto drop-shadow-xl transform transition hover:scale-105" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-700 relative z-10 backdrop-blur-sm bg-opacity-95 dark:bg-opacity-95">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Pancingan.
            </div>
        </div>
    </body>
</html>
