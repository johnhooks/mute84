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
                <media-theme template="media-theme-player" class="inline-block w-full leading-none">
                    <audio slot="media" id="audio" src="{{ storage_url($post->file->file_path) }}"
                        type="audio/mpeg" />
                </media-theme>
            </div>
        </div>
    </div>
</x-layouts.visual>
