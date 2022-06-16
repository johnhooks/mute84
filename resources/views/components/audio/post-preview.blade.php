@props(['post', 'user'])

<li x-data="audio('{{ storage_url($post->file->file_path) }}')">
    <div class="block hover:bg-gray-50" x-on:click="play">
        <div class="flex items-center px-4 py-4 sm:px-6">
            <div class="flex w-full items-center justify-between">
                <div class="truncate">
                    <div class="flex text-sm">
                        <p class="truncate font-bold text-indigo-600">{{ $post->title }}</p>
                    </div>
                    <div class="mt-2 flex">
                        <div class="flex items-center text-sm text-gray-500">
                            <!-- Heroicon name: solid/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                      clip-rule="evenodd" />
                            </svg>
                            <p>
                                {{ $post->user->name }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-0 ml-5 flex justify-center">
                    @if ($post->user_id === $user->id)
                        <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="mr-4 py-4">
                            <button class="flex items-center">
                                <x-icon.pencil-alt class="h-6 w-6 flex-shrink-0 text-gray-400 sm:hidden" />
                                <span class="hidden text-indigo-500 hover:text-indigo-300 sm:inline">edit</span>
                            </button>
                        </a>
                    @endif
                    @if ($post->user_id === $user->id)
                        <form action="{{ route('posts.destroy', ['id' => $post->id]) }}" method="POST"
                              class="mr-4" x-on:submit="confirm">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="flex items-center py-4">
                                <x-icon.trash class="h-6 w-6 flex-shrink-0 text-gray-400 sm:hidden" />
                                <span class="hidden text-indigo-500 hover:text-indigo-300 sm:inline">delete</span>
                            </button>
                        </form>
                    @endif
                    <div class="flex py-4">
                        <x-play-icon class="inline-block h-6 w-6 text-gray-400"
                                     x-show="!($store.player.url === $data.url && $store.player.playing)" />
                        <x-pause-icon class="inline-block h-6 w-6 text-gray-400" x-cloak
                                      x-show="$store.player.url === $data.url && $store.player.playing" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
