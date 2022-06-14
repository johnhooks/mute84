@props(['title', 'subtitle' => ''])

<div class="overflow-hidden bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $title }}</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $subtitle }}</p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">
            {{ $slot }}
        </dl>
    </div>
</div>
