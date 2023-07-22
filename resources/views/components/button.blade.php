<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'flex w-full justify-center px-3.5 py-2.5 text-sm font-semibold shadow-sm bg-lime-400 text-black border-2 border-lime-400 hover:bg-black hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lime-400',
    ]) }}
>
    {{ $slot }}
</button>
