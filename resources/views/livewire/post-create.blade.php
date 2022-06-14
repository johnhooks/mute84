<div>
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">Audio Post</h3>
        <p class="mt-1 text-sm text-gray-500">
            {{--  --}}
        </p>
    </div>

    <form wire:submit.prevent="submit" class="space-y-8 divide-y divide-gray-200">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                <x-form.text-input wire:model="title" label="Title" id="post-title">
                    @error('title')
                        <x-slot:error> {{ $message }} </x-slot:error>
                    @enderror
                </x-form.text-input>

                <x-form.permalink wire:model="slug" label="Permalink" id="post-permalink" :url="url('/') . '/' . auth()->user()->slug . '/'">
                    @error('slug')
                        <x-slot:error> {{ $message }} </x-slot:error>
                    @enderror
                </x-form.permalink>

                <x-form.textarea wire:model="description" label="Description" id="post-description" rows="3">
                    @error('description')
                        <x-slot:error> {{ $message }} </x-slot:error>
                    @enderror
                </x-form.textarea>

                <x-form.audio-upload wire:model="file" label="Audio File" id="post-file-upload" accept="audio/mpeg">
                    @error('file')
                        <x-slot:error> {{ $message }} </x-slot:error>
                    @enderror
                </x-form.audio-upload>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="post-status" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Status
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="relative max-w-lg rounded-md shadow-sm">
                            <select wire:model="status" id="post-status"
                                    class="block w-full min-w-0 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="draft">Draft</option>
                                <option value="unlisted">Unlisted</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600" id="email-error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save Post
                </button>
            </div>
        </div>
    </form>
</div>
