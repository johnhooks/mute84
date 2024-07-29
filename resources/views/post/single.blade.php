<x-layouts.visual>
    <x-slot:title>
        {{ $post->title }} - {{ $post->user->name }}
    </x-slot:title>
    <x-slot:scripts>
        @vite(['resources/js/player.js'])
    </x-slot:scripts>
    <div class="flex min-h-screen flex-col">
        <div style="min-height: 50vh;">
        </div>
        <div class="pt-8">
            <div class="mx-auto max-w-6xl py-4 sm:px-6 lg:px-8">
                <div class="flex flex-col justify-center">
                    <h1 class="text-center text-2xl font-semibold text-gray-50">{{ $post->title }}</h1>
                    <p class="text-center text-gray-400">by {{ $post->user->name }}</p>
                    <p class="text-center text-gray-400">
                        @if ($post->status === 'published')
                            {{ \Carbon\Carbon::parse($post->published_at)->format('F jS Y') }}
                        @else
                            {{ $post->status }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-center space-x-4 pt-2 sm:pt-4">
                <button id="play-btn" type="button"
                    class="inline-flex items-center rounded-full border border-transparent bg-indigo-600 p-3 text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <!-- Heroicon name: outline/plus-sm -->
                    <svg id="play" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path
                            d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z" />
                    </svg>
                    <svg id="pause" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path
                            d="M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5zm5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5z" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-center">
                <audio id="audio" src="{{ storage_url($post->file->file_path) }}" type="audio/mpeg" />
            </div>
        </div>
    </div>
</x-layouts.visual>
