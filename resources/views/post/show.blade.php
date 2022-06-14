<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Audio Post') . ' - ' . $post->title }}
        </h2>
    </x-slot>

    <div class="py-0 sm:py-12">
        <div class="mx-auto max-w-7xl pb-32 sm:px-6 lg:px-8">
            <x-list.description-list title="Audio Post Details">
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
                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                            <div class="flex w-0 flex-1 items-center">
                                <!-- Heroicon name: solid/paper-clip -->
                                <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                          clip-rule="evenodd" />
                                </svg>
                                <span class="ml-2 w-0 flex-1 truncate">{{ $post->file->name }}</span>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="{{ storage_url($post->file->file_path) }}"
                                   class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Download
                                </a>
                            </div>
                        </li>
                </x-list.item>
            </x-list.description-list>
        </div>
    </div>
</x-app-layout>
