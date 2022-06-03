<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-0 sm:py-12">
        <div class="mx-auto max-w-7xl pb-32 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <a href="{{ url('/upload-file') }}"
                       class="text-base font-semibold text-indigo-600 hover:text-indigo-500">Upload new audio file</a>
                </div>
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
            </div>

            <h3 class="py-4 px-4 text-xl font-semibold text-gray-800 sm:py-6 sm:px-0">
                Audio List
            </h3>

            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse ($files as $file)
                        <x-audio.list-item :file="$file" :user="$user" />
                    @empty
                        <li>No files</li>
                    @endforelse
                </ul>
            </div>
        </div>

</x-app-layout>
