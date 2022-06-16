@props(['title'])

<div class="border-b border-gray-200 px-4 py-5 sm:px-6">
    <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
        <div class="ml-4 mt-2">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ $title }}
            </h3>
        </div>
        <div class="ml-4 mt-2 flex-shrink-0">
            {{ $slot }}
        </div>
    </div>
</div>
