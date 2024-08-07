<x-layouts.visual>
    <x-slot:title>
        tapeloop-01 - mute84
    </x-slot:title>
    <x-slot:scripts>
        @vite(['resources/js/player.js'])
    </x-slot:scripts>

    <div class="min-h-screen flex flex-col">
        <div style="min-height: 50vh;">
        </div>
        <div class="pt-8">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col justify-center">
                    <h1 class="font-semibold text-2xl text-gray-50 text-center">tapeloop-01</h1>
                    <p class="text-gray-400 text-center">by mute84</p>
                </div>
            </div>

            <div class="flex items-center justify-center space-x-4 pt-2 sm:pt-4">
                <media-theme template="media-theme-player">
                    <audio slot="media" id="audio" src="/storage/dadbeats_20220525_08_tape_loop.MP3"
                        type="audio/mpeg" />
                </media-theme>
            </div>
        </div>
    </div>
</x-layouts.visual>
