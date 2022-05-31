<x-layouts.visual>
    <x-slot:title>
        rush - johnhooks
    </x-slot:title>
    <x-slot:scripts>
        <script src="{{ mix('js/three.js') }}" defer></script>
    </x-slot:scripts>
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
</x-layouts.visual>
