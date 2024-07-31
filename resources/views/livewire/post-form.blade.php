<form wire:submit="submit" class="space-y-8">
    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
        <div class="space-y-6 sm:space-y-5">
            <x-form.text-input wire:model.live.debounce.500ms="post.title" label="Title" id="post-title">
                @error('post.title')
                    <x-slot:error> {{ $message }} </x-slot:error>
                @enderror
            </x-form.text-input>

            <x-form.permalink wire:model.blur="post.slug" label="Permalink" id="post-permalink"
                              :url="url('/') . '/' . auth()->user()->slug . '/'">
                @error('post.slug')
                    <x-slot:error> {{ $message }} </x-slot:error>
                @enderror
            </x-form.permalink>

            <x-form.textarea wire:model.blur="post.description" label="Description" id="post-description"
                             rows="3">
                @error('post.description')
                    <x-slot:error> {{ $message }} </x-slot:error>
                @enderror
            </x-form.textarea>

            @if ($file)
                <x-form.form-control id="post-file-preview" label="Audio File">
                    <x-audio.preview id="post-file-preview" :url="$file->temporaryUrl()" :name="$file->getClientOriginalName()" />
                </x-form.form-control>
            @else
                <x-form.file-upload id="post-file-upload" label="Audio File" wire:model.live="file" :file="$post->file">
                    @error('file')
                        <x-slot:error> {{ $message }} </x-slot:error>
                    @enderror
                </x-form.file-upload>
            @endif

            <x-form.select wire:model.live="post.status" label="Status" id="post-status">
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
