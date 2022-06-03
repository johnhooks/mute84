@props(['file'])

<div class="flex pt-2" x-data="audio('{{ storage_url($file->file_path) }}')">
    <div class="flex text-gray-500 hover:text-indigo-500 cursor-pointer" x-on:click="play">
        <span>
            <x-play-icon x-show="!($store.player.url === $data.url && $store.player.playing)" />
            <x-pause-icon x-cloak x-show="$store.player.url === $data.url && $store.player.playing" />
        </span>
        <span class="pl-4  cursor-pointer">{{ $file->name }}</span>
    </div>
    <span class=" pl-4">
        <form action="{{ route('files.destroy', ['id' => $file->id]) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="text-indigo-500 hover:text-indigo-300">delete</button>
        </form>
    </span>
</div>
