<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-0 sm:py-12">
        <div class="mx-auto max-w-7xl pb-32 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <a href="{{ route('posts.create') }}"
                       class="text-base font-semibold text-indigo-600 hover:text-indigo-500">
                        Create a new audio post
                    </a>
                </div>
                <x-audio.visualizer />
            </div>

            <h3 class="py-4 px-4 text-xl font-semibold text-gray-800 sm:py-6 sm:px-0">
                Your recent audio posts
            </h3>

            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse ($posts as $post)
                        <x-audio.post-preview :post="$post" :user="$user" />
                    @empty
                        <li>No files</li>
                    @endforelse
                </ul>
            </div>
        </div>

</x-app-layout>
