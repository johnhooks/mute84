<x-layouts.visual>
    <x-slot:title>
        NE2 - scottswenson
    </x-slot:title>
    <x-slot:scripts>
        <script src="{{ mix('js/player.js') }}" defer></script>
    </x-slot:scripts>
    <div class="relative min-h-screen">
        <div class="absolute inset-x-0 bottom-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col justify-center">
                    <h1 class="font-semibold text-2xl text-gray-50 text-center">NE2</h1>
                    <p class="text-gray-400 text-center">by scottswenson</p>
                </div>
            </div>
            <div class="flex justify-center items-center pb-4">
                <audio id="tapeloop" src="/storage/scottswenson_ne2.mp3" controls type="audio/mpeg" />
            </div>
        </div>
    </div>
</x-layouts.visual>
