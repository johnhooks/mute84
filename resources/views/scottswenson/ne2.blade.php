<x-layouts.visual>
    <x-slot:title>
        NE2 - scottswenson
    </x-slot:title>
    <x-slot:scripts>
        <script src="{{ mix('js/player.js') }}" defer></script>
    </x-slot:scripts>
    <div class="min-h-screen flex flex-col">
        <div style="min-height: 50vh;">
        </div>
        <div class="pt-8">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col justify-center">
                    <h1 class="font-semibold text-2xl text-gray-50 text-center">NE2</h1>
                    <p class="text-gray-400 text-center">by scottswenson</p>
                </div>
            </div>
            <div class="flex justify-center items-center space-x-4 pt-2 sm:pt-4">
                <button id="play-btn" type="button"
                    class="inline-flex items-center p-3 border border-transparent rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <!-- Heroicon name: outline/plus-sm -->
                    <svg id="play" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path
                            d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z" />
                    </svg>
                    <svg id="pause" class="h-6 w-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path
                            d="M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5zm5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5z" />
                    </svg>
                </button>
            </div>
            <div class="flex justify-center items-center">
                <audio id="audio" src="/storage/scottswenson_ne2.mp3" type="audio/mpeg" />
            </div>
        </div>
    </div>
</x-layouts.visual>
