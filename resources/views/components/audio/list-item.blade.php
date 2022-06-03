@props(['file', 'user'])

<li x-data="audio('{{ storage_url($file->file_path) }}')">
    <div class="block hover:bg-gray-50" x-on:click="play">
        <div class="px-4 py-4 flex items-center sm:px-6">
            <div class="flex items-center justify-between w-full">
                <div class="truncate">
                    <div class="flex text-sm">
                        <p class="font-medium text-indigo-600 truncate">{{ $file->name }}</p>
                    </div>
                    <div class="mt-2 flex">
                        <div class="flex items-center text-sm text-gray-500">
                            <!-- Heroicon name: solid/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p>
                                {{ $file->user->name }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-0 ml-5 flex">
                    @if ($file->user_id === $user->id)
                        <form action="{{ route('files.destroy', ['id' => $file->id]) }}" method="POST"
                            class="mr-4 sm-mr8" x-on:submit="confirm">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="flex items-center">
                                <!-- Heroicon name: solid/trash -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="flex-shrink-0 h-6 w-6 text-gray-400 sm:hidden" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-indigo-500 hover:text-indigo-300 hidden sm:inline">delete</span>
                            </button>
                        </form>
                    @endif
                    <div class="flex">
                        <x-play-icon class="inline-block text-gray-400"
                            x-show="!($store.player.url === $data.url && $store.player.playing)" />
                        <x-pause-icon class="inline-block text-gray-400" x-cloak
                            x-show="$store.player.url === $data.url && $store.player.playing" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
