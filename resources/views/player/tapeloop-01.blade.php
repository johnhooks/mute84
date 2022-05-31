<x-layouts.visual>
    <x-slot:title>
        tapeloop-01 - mute84
    </x-slot:title>
    <x-slot:scripts>
        <script src="{{ mix('js/player.js') }}" defer></script>
    </x-slot:scripts>
    <div class="relative min-h-screen">
        <div class="absolute inset-x-0 bottom-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-4">
                <div class="flex justify-center">
                    <h1 class="font-semibold text-2xl text-gray-50" style="color:##fff;">tapeloop-01</h1>
                </div>
            </div>
            <div class="flex justify-center items-center pb-4">
                <audio id="tapeloop" src="/storage/dadbeats_20220525_08_tape_loop.MP3" controls type="audio/mpeg" />
            </div>
        </div>
    </div>
</x-layouts.visual>
