<!DOCTYPE html>
<html lang="en">

<head>
    <title>rush - johnhooks</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <style>
        html {
            margin: 0;
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
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/three.js') }}" defer></script>

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

<body>
    <div id="overlay"
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 flex flex-col">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <h1 class="font-semibold text-gray-800 dark:text-gray-400 text-4xl">rush</h1>
            </div>
            <div id="info" class="pt-2">by johnhooks</a></div>
            <div class="pt-4 flex justify-center sm:justify-start">
                <button id="startButton" type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Play</button>
            </div>
        </div>
    </div>
    <div id="container"></div>
</body>

</html>
