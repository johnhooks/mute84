<form wire:submit.prevent="submit" class="space-y-8">
    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
        <div class="space-y-6 sm:space-y-5">
            <x-form.text-input wire:model.debounce.500ms="post.title" label="Title" id="post-title">
                @error('post.title')
                    <x-slot:error> {{ $message }} </x-slot:error>
                @enderror
            </x-form.text-input>

            <x-form.permalink wire:model.lazy="post.slug" label="Permalink" id="post-permalink"
                              :url="url('/') . '/' . auth()->user()->slug . '/'">
                @error('post.slug')
                    <x-slot:error> {{ $message }} </x-slot:error>
                @enderror
            </x-form.permalink>

            <x-form.textarea wire:model.lazy="post.description" label="Description" id="post-description" rows="3">
                @error('post.description')
                    <x-slot:error> {{ $message }} </x-slot:error>
                @enderror
            </x-form.textarea>

            {{-- <x-form.audio-upload wire:model.debounce.500ms="file" label="Audio File" id="post-file-upload"
                                 :file="$post->file"
                                 accept="audio/mpeg">
                @error('file')
                    <x-slot:error> {{ $message }} </x-slot:error>
                @enderror
            </x-form.audio-upload> --}}

            <x-form.form-control id="post-file-upload" label="Audio File">
                @error('file')
                    <x-slot:error> {{ $message }} </x-slot:error>
                @enderror
                <div x-data="{ isUploading: false, progress: 0 }"
                     x-on:livewire-upload-start="isUploading = true"
                     x-on:livewire-upload-finish="isUploading = false"
                     x-on:livewire-upload-error="isUploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress"
                     class="relative">
                    @if ($file)
                        <x-audio.preview :url="$file->temporaryUrl()" :name="$file->getClientOriginalName()" />
                    @elseif ($post->file)
                        <x-audio.preview :url="storage_url($post->file->file_path)" :name="$post->file->name" />
                    @endif
                    <div
                         class="pb-6{{ $file || $post->file ? ' hidden' : '' }} w-full rounded-md border-2 border-dashed border-gray-300 px-6 pt-5">
                        <input type="file" id="post-file-upload" wire:model.debounce.500ms="file"
                               class="file-upload absolute inset-0 z-50 m-0 h-full w-full p-0 opacity-0 outline-none"
                               x-on:change="console.log($event.target.files);"
                               x-on:dragover="$el.classList.add('active')"
                               x-on:dragleave="$el.classList.remove('active')"
                               x-on:drop="$el.classList.remove('active')">
                        <div class="space-y-1 text-center">
                            <x-icon.audio class="mx-auto h-12 w-12 text-gray-400" />
                            <div class="text-sm text-gray-600">
                                <label for="post-file-upload"
                                       class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                    <span>Upload a file</span>
                                </label>
                                <p class="inline-block pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">MP3 up to 8MB</p>
                        </div>
                    </div>
                    <div x-cloak x-show="isUploading">
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
                    </div>
                </div>
            </x-form.form-control>

            <x-form.select wire:model="post.status" label="Status" id="post-status">
                <option value="draft">Draft</option>
                <option value="unlisted">Unlisted</option>
                <option value="published">Published</option>
                @error('post.status')
                    <x-slot:error> {{ $message }} </x-slot:error>
                @enderror
            </x-form.select>
        </div>
    </div>

    <div class="py-3 sm:border-t sm:border-gray-200 sm:py-5 sm:px-6">
        <div class="flex justify-end">
            <a href="javascript:history.back()">
                <button type="button"
                        class="mr-2 rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancel
                </button>
            </a>

            <button type="submit"
                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Save Post
            </button>
        </div>
    </div>
</form>
