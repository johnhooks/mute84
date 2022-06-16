@props(['url', 'name'])

<li x-data="audio('{{ $url }}')"
    x-on:click="play"
    class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
    <div class="flex w-0 flex-1 items-center">
        <x-icon.audio class="h-5 w-5 flex-shrink-0 text-gray-400" />
        <span class="ml-2 w-0 flex-1 truncate">{{ $name }}</span>
    </div>
    <div class="ml-4 flex flex-shrink-0 items-center">
        <a href="{{ $url }}"
           class="mr-4 font-medium text-indigo-600 hover:text-indigo-500">
            Download
        </a>
        <div class="flex">
            <x-play-icon class="inline-block h-6 w-6 text-gray-400"
                         x-show="!($store.player.url === $data.url && $store.player.playing)" />
            <x-pause-icon class="inline-block h-6 w-6 text-gray-400" x-cloak
                          x-show="$store.player.url === $data.url && $store.player.playing" />
        </div>
    </div>
