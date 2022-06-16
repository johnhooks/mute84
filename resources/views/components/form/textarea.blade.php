@props(['id', 'label', 'rows' => '3'])

<x-form.form-control :id="$id" :label="$label">
    @if (isset($error))
        <x-slot:error>{{ $error }}</x-slot:error>
    @endif
    <textarea rows="{{ $rows }}" id="{{ $id }}"
              {{ $attributes->merge(['class' => 'max-w-lg shadow-sm block w-full sm:text-sm rounded-md ' . (isset($error) ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500')]) }}>
    </textarea>
</x-form.form-control>
