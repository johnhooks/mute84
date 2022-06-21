<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Audio Post') . ' - ' . $post->title }}
        </h2>
    </x-slot>

    <div class="py-0 sm:py-12">
        <x-card.card>

            <x-card.heading title=" Audio Post">
                @if (auth()->user()->can('post.edit', $post))
                    <a href="{{ route('posts.edit', $post) }}">
                        <button
                                class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Edit Post
                        </button>
                    </a>
                @endif
            </x-card.heading>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <x-list.item label="title">{{ $post->title }}</x-list.item>
                    <x-list.item label="description">{{ $post->description }}</x-list.item>
                    <x-list.item label="owner">{{ $post->user->name }}</x-list.item>
                    <x-list.item label="permalink">
                        @php($permalink = $post->permalink())
                        <a href="{{ $permalink }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            {{ $permalink }}
                        </a>
                    </x-list.item>
                    <x-list.item label="id">{{ $post->id }}</x-list.item>
                    <x-list.item label="post status">{{ $post->status }}</x-list.item>
                    <x-list.item label="files">

                        <ul role="list" class="divide-y divide-gray-200 rounded-md border border-gray-200">
                            <x-audio.preview :url="storage_url($post->file->file_path)" :name="$post->file->name" />
                    </x-list.item>
                </dl>
            </div>
        </x-card.card>
    </div>
</x-app-layout>
