<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('New Audio Post') }}
        </h2>
    </x-slot>

    <div class="py-0 sm:py-12">
        <x-card.card>
            <x-card.heading title="Audio Post" />
            <div class="px-4 py-5 sm:p-0">
                <livewire:post-create :post="$post" />
            </div>
        </x-card.card>
    </div>
</x-app-layout>
