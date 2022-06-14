@props(['id', 'label'])

<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
        {{ $label }}
    </label>
    {{-- based off https://codepen.io/jjjrmy/pen/gOPvmdv --}}
    <div class="mt-1 sm:col-span-2 sm:mt-0">
        <div x-data="{ files: null }"
             class="relative max-w-lg rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
            <input type="file" id="{{ $id }}" {{ $attributes }}
                   class="file-upload absolute inset-0 z-50 m-0 h-full w-full p-0 opacity-0 outline-none"
                   x-on:change="files = $event.target.files; console.log($event.target.files);"
                   x-on:dragover="$el.classList.add('active')"
                   x-on:dragleave="$el.classList.remove('active')"
                   x-on:drop="$el.classList.remove('active')">
            <div class="flex justify-center">
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
                    <div class="space-y-1 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M8.5 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11a.5.5 0 0 1 .5-.5zm-2 2a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm-6 1.5A.5.5 0 0 1 5 6v4a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm8 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm-10 1A.5.5 0 0 1 3 7v2a.5.5 0 0 1-1 0V7a.5.5 0 0 1 .5-.5zm12 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0V7a.5.5 0 0 1 .5-.5z" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="{{ $id }}"
                                   class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                <span>Upload a file</span>

                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">MP3 up to 8MB</p>
                    </div>
                </template>

            </div>
        </div>
        @if (isset($error))
            <p class="mt-2 text-sm text-red-600">
                {{ $error }}
            </p>
        @endif
    </div>
</div>
