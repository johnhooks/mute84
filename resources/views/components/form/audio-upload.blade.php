@props(['id', 'label', 'file'])

{{-- based off https://codepen.io/jjjrmy/pen/gOPvmdv --}}
{{-- * The states
    * - previously saved
    * - no file
    * - file selected
    * - file uploading
    * - file uploaded --}}
<x-form.form-control :id="$id" :label="$label">
    @if (isset($error))
        <x-slot:error>{{ $error }}</x-slot:error>
    @endif

    <div x-data="{ files: null }"
         class="relative">

        <div class="flex justify-center">
            {{-- TODO Remove the line below and use it to preview the uploaded file --}}
            {{ $file && $file->file_path }}
            <template x-if="files !== null">
                <div class="flex flex-col space-y-1">
                    <template x-for="(_,index) in Array.from({ length: files.length })">
                        <div class="flex flex-row items-center space-x-2">
                            <template x-if="files[index].type.includes('audio/')"><i
                                   class="far fa-file-audio fa-fw"></i></template>
                            <template x-if="files[index].type.includes('application/')"><i
                                   class="far fa-file-alt fa-fw"></i></template>
                            <template x-if="files[index].type.includes('image/')"><i
                                   class="far fa-file-image fa-fw"></i></template>
                            <template x-if="files[index].type.includes('video/')"><i
                                   class="far fa-file-video fa-fw"></i></template>
                            <span class="font-medium text-gray-900" x-text="files[index].name">Uploading</span>
                            <span class="self-end text-xs text-gray-500"
                                  x-text="filesize(files[index].size)">...</span>
                        </div>
                    </template>
                </div>
            </template>
            <template x-if="files === null">
                <div class="w-full rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                    <input type="file" id="{{ $id }}" {{ $attributes }}
                           class="file-upload absolute inset-0 z-50 m-0 h-full w-full p-0 opacity-0 outline-none"
                           x-on:change="files = $event.target.files; console.log($event.target.files);"
                           x-on:dragover="$el.classList.add('active')"
                           x-on:dragleave="$el.classList.remove('active')"
                           x-on:drop="$el.classList.remove('active')">
                    <div class="space-y-1 text-center">
                        <x-icon.audio class="mx-auto h-12 w-12 text-gray-400" />
                        <div class="text-sm text-gray-600">
                            <label for="{{ $id }}"
                                   class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                <span>Upload a file</span>

                            </label>
                            <p class="inline-block pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">MP3 up to 8MB</p>
                    </div>
                </div>
            </template>
        </div>
    </div>
</x-form.form-control>
