<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-0 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ url('/upload-file') }}"
                        class="text-base font-semibold text-indigo-600 hover:text-indigo-500">Upload new audio file</a>
                </div>
                <div id="visualizer" x-data="visualizer"
                    class="fixed bottom-8 left-0 w-full sm:left-auto sm:right-8 sm:w-1/2 overflow-hidden shadow-sm sm:rounded-lg"
                    x-on:click="toggle" style="height: 100px; box-sizing: border-box; background-color: rgb(33 31 147)">

                    <div class="flex absolute right-4 h-full items-center">
                        <x-play-icon class="text-gray-400 h-12 w-12 opacity-50" x-show="!$store.player.playing" />
                        <x-pause-icon class="text-gray-400 h-12 w-12 opacity-50" x-cloak
                            x-show="$store.player.playing" />
                    </div>
                    {{-- <canvas x-ref="canvas" height="50" style="height: 50px"></canvas> --}}

                </div>

                <h3 class="text-xl font-semibold text-gray-800 py-4 sm:py-6 px-4 sm:px-6">Audio List</h3>

                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul role="list" class="divide-y divide-gray-200">
                        @forelse ($files as $file)
                            <x-audio.list-item :file="$file" :user="$user" />
                        @empty
                            <li>No files</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

</x-app-layout>
