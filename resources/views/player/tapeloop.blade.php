<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>tapeloop-01</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

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

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ mix('js/player.js') }}" defer></script>

    <script>
        if (!window.MediaRecorder) {
            document.write(
                decodeURI('%3Cscript defer src="/js/polyfill.js">%3C/script>')
            )
        }
    </script>

    @if (config('app.env') == 'local')
        <script src="http://localhost:35729/livereload.js"></script>
    @endif
</head>

<body class="antialiased">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-4">
        <div class="flex justify-center">
            <h1 class="font-semibold text-2xl text-gray-50" style="color:##fff;">tapeloop-01</h1>
        </div>
    </div>
    <div class="flex justify-center items-center pb-4">
        <audio id="tapeloop" src="/storage/dadbeats_20220525_08_tape_loop.MP3" controls type="audio/mpeg" />
    </div>
</body>

</html>
