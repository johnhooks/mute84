@props(['file'])

<div class="flex pt-2" x-data="audio('{{ $file->file_path }}')">
    <button class="text-gray-500 hover:text-indigo-500" x-on:click="play">
        <x-play-icon x-show="!($store.player.url === $data.url && $store.player.playing)" />
        <x-pause-icon x-cloak x-show="$store.player.url === $data.url && $store.player.playing" />
    </button>
    <span class="pl-2">{{ $file->name }}</span>
</div>
