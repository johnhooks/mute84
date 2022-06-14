@props(['id', 'label', 'rows' => '3'])

<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
        {{ $label }} </label>
    <div class="mt-1 max-w-lg sm:col-span-2 sm:mt-0">
        <textarea rows="{{ $rows }}" id="{{ $id }}"
                  {{ $attributes->merge(['class' => 'max-w-lg shadow-sm block w-full sm:text-sm rounded-md ' . (isset($error) ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500')]) }}></textarea>
        @if (isset($error))
            <p class="mt-2 text-sm text-red-600">
                {{ $error }}
            </p>
        @endif
    </div>
</div>
