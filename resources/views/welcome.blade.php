<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>mute84</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    @if (config('app.env') == 'local')
        <script src="http://localhost:35729/livereload.js"></script>
    @endif
</head>

<body class="antialiased">
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col justify-center pt-8 sm:justify-start sm:pt-0">
                <h1 class="font-semibold text-gray-800 dark:text-gray-400 text-4xl">mute84</h1>
                <div class="mt-3">
                    <a href="{{ url('/visualizer') }}"
                        class="text-base font-semibold text-indigo-600 hover:text-indigo-500">audio visualizer 01</a>
                </div>
                <div class="mt-3">
                    <a href="{{ url('/tapeloop-01') }}"
                        class="text-base font-semibold text-indigo-600 hover:text-indigo-500">tapeloop-01 &ndash;
                        mute84</a>
                </div>
                <div class="mt-3">
                    <a href="{{ url('/johnhooks/rush') }}"
                        class="text-base font-semibold text-indigo-600 hover:text-indigo-500">rush &ndash; johnhooks</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
