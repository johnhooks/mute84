@props(['id', 'label', 'url'])

<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
        {{ $label }} </label>
    <div class="mt-1 sm:col-span-2 sm:mt-0">
        <div class="relative max-w-lg rounded-md shadow-sm">
            <div class="flex">
                <span
                      class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">
                    {{ $url }}
                </span>

                <input type="text" id="{{ $id }}"
                       {{ $attributes->merge(['class' => 'flex-1 block w-full min-w-0 rounded-none rounded-r-md sm:text-sm ' . (isset($error) ? 'pr-10 border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'focus:ring-indigo-500 focus:border-indigo-500 border-gray-300')]) }}>
            </div>
            @if (isset($error))
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <!-- Heroicon name: solid/exclamation-circle -->
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                    </svg>
                </div>
            @endif
        </div>
        @if (isset($error))
            <p class="mt-2 text-sm text-red-600">
                {{ $error }}
            </p>
        @endif
    </div>
</div>
