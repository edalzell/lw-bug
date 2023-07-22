@props(['id', 'title', 'type' => 'text'])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium leading-6 text-black">{{ $title }}</label>
    <div class="mt-1">
        <input
            {{ $attributes->wire('model') }}
            id="{{ $id }}"
            type="{{ $type }}"
            class="block w-full border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-lime-300 sm:text-sm sm:leading-6 font-mono">
    </div>
</div>
