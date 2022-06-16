<div id="visualizer" x-data="visualizer"
     class="fixed bottom-0 left-0 w-full overflow-hidden shadow-sm sm:bottom-6 sm:right-6 sm:left-auto sm:w-1/2 sm:rounded-lg lg:bottom-8 lg:right-8"
     style="height: 100px; box-sizing: border-box; background-color: rgb(33 31 147)"
     x-on:click="toggle">
    <div class="absolute right-4 flex h-full items-center">
        <x-play-icon class="h-12 w-12 text-gray-400 opacity-50" x-show="!$store.player.playing" />
        <x-pause-icon class="h-12 w-12 text-gray-400 opacity-50" x-cloak
                      x-show="$store.player.playing" />
    </div>
    {{-- <canvas></canvas> --}}
</div>
