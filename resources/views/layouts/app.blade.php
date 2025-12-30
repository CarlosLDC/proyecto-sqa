<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LaraFy CMS') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen font-sans antialiased text-gray-900 overflow-x-hidden" data-testid="main-layout">
    <!-- Animated Background Gradients -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-100/50 blur-[120px] animate-pulse">
        </div>
        <div class="absolute top-[20%] -right-[10%] w-[35%] h-[45%] rounded-full bg-violet-100/50 blur-[120px] animate-pulse"
            style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[45%] h-[35%] rounded-full bg-blue-100/50 blur-[120px] animate-pulse"
            style="animation-delay: 4s;"></div>
    </div>

    @include('components.navbar')

    <main class="py-12 relative z-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <footer class="mt-20 py-12 border-t border-gray-200 glass-panel !bg-white/40" data-testid="footer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex flex-col items-center justify-center space-y-4">
                <div
                    class="text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600">
                    LaraFy CMS
                </div>
                <div class="text-sm text-gray-500 max-w-sm">
                    {{ __('Your premium blogging platform built with Laravel and Tailwind CSS.') }}
                </div>
                <div class="pt-6 text-xs text-gray-400">
                    &copy; {{ date('Y') }} LaraFy CMS. {{ __('All rights reserved') }}.
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notifications -->
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-4"
            class="fixed bottom-8 right-8 z-50 flex items-center bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-2xl border border-white/10 glass-panel !bg-gray-900/90"
            data-testid="toast">
            <svg class="h-6 w-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-bold tracking-tight">{{ session('success') }}</span>
            <button @click="show = false" class="ml-4 text-gray-400 hover:text-white transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif
</body>

</html>