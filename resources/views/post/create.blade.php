<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('New Audio Post') }}
        </h2>
    </x-slot>

    <div class="py-0 sm:py-12">
        <div class="mx-auto max-w-7xl pb-32 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white px-4 py-4 sm:py-8 sm:px-6 lg:px-8">
                <livewire:post-create :post="$post" />
            </div>
        </div>
    </div>
</x-app-layout>
