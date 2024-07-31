<x-layouts.visual>
    <x-slot:title>
        sampler
    </x-slot:title>
    <x-slot:scripts>
        @vite(['resources/js/sampler.js'])
    </x-slot:scripts>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-4">
        <div class="flex justify-center">
            <h1 class="font-semibold text-2xl text-gray-50" style="color:#ffc600;">sampler</h1>
        </div>
        <div class="flex justify-center items-center space-x-4 py-4">
            <button type="button" id="record-btn"
                class="inline-flex items-center p-1.5 border border-transparent rounded-full shadow-sm text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg id="record" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 13A5 5 0 1 0 8 3a5 5 0 0 0 0 10z" />
                </svg>
                <svg id="stop" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="M5 3.5h6A1.5 1.5 0 0 1 12.5 5v6a1.5 1.5 0 0 1-1.5 1.5H5A1.5 1.5 0 0 1 3.5 11V5A1.5 1.5 0 0 1 5 3.5z" />
                </svg>
            </button>
            <button type="button" id="play-btn"
                class="inline-flex items-center p-1.5 border border-transparent rounded-full shadow-sm text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg id="play" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z" />
                </svg>
                <svg id="pause" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5zm5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5z" />
                </svg>
            </button>
        </div>
    </div>
    <audio id="buffer" />
</x-layouts.visual>
