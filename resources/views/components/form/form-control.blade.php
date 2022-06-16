@props(['id', 'label'])

<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:pt-5">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
        {{ $label }}
    </label>

    <div class="mt-1 max-w-lg sm:col-span-2 sm:mt-0">
        {{ $slot }}
        @if (isset($error))
            <p class="mt-2 text-sm text-red-600">
                {{ $error }}
            </p>
        @endif
    </div>
</div>
