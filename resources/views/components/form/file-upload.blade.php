@props(['id', 'label', 'file'])

{{-- based off https://codepen.io/jjjrmy/pen/gOPvmdv --}}
{{-- * The states
     * - previously saved - this should possibly be handled by the parent of the component
     * - no file
     * - file selected (pretty sure when this happens we go strait to file uploading)
     * - file upload error
     * - file uploading
     * - file uploaded --}}

<x-form.form-control id="{{ $id }}" label="{{ $label }}">
    @if (isset($error))
        <x-slot:error> {{ $error }} </x-slot:error>
    @endif

    <div x-data="{ isUploading: false, progress: 0, error: false, file: @entangle('file').live }"
         x-on:livewire-upload-start="isUploading = true"
         x-on:livewire-upload-finish="isUploading = false; progress = 0; console.log(file);"
         x-on:livewire-upload-error="error = true ;isUploading = false"
         x-on:livewire-upload-progress="progress = $event.detail.progress">

        {{-- to remove --}}
        {{-- I believe it would be best for the parent componet to handle whether or not to display the form or file previews --}}

        {{-- end to remove --}}

        {{-- This needs to be more robust --}}
        <template x-if="error">
            <p x-on:click="error = false" class="text-sm text-red-600">
                There was an error while uploading the file.
            </p>
        </template>

        {{-- I'm going to try to use a template here. I don't know if it'll work right --}}
        <div x-show="!isUploading">
            <div class="relative w-full rounded-md border-2 border-dashed border-gray-300 px-6 pb-6 pt-5">
                {{-- the attributes are all added to the file input element --}}

                <input type="file" id="{{ $id }}" {{ $attributes }}
                       class="file-upload absolute inset-0 z-50 m-0 h-full w-full p-0 opacity-0 outline-none"
                       x-on:change="console.log($event.target.files);"
                       x-on:dragover="$el.classList.add('active')"
                       x-on:dragleave="$el.classList.remove('active')"
                       x-on:drop="$el.classList.remove('active')">

                {{-- this could possibly be the slot --}}
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
                {{-- end slot --}}

            </div>
        </div>

        {{-- progress indicator --}}
        {{-- totally an Alpine component --}}
        <template x-if="isUploading">
            {{-- https://tailwindcomponents.com/component/animated-dynamic-progress-bar --}}
            <div class="h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700"
                 role="progressbar"
                 x-bind:aria-valuenow="progress"
                 aria-valuemin="0"
                 aria-valuemax="100">
                <div class="h-2.5 rounded-full bg-blue-600" style="width: 45%"
                     x-bind:style="`width: ${progress}%; transition: width 1s;`">
                </div>
            </div>
        </template>
        {{-- end progress indicator --}}

    </div>
</x-form.form-control>
