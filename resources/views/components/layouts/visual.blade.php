<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'visualizer - mute84' }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    @vite(['resources/css/app.css'])

    <style>
        html {
            margin: 0;
            background: black;
        }

        canvas {
            width: 100%;
            height: 100%;
        }

        body {
            min-height: 100vh;
            display: grid;
            grid-template-rows: 1fr;
            margin: 0;
        }
    </style>

    @livewireStyles

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    @livewireScripts
    {{ $scripts ?? '' }}
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="min-h-screen">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
