@props(['active'])
@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#ff6347] text-sm font-medium leading-5 text-[#ff6347] focus:outline-none focus:border-[#ff6347] transition duration-150 ease-in-out' // ATIVO: Texto Coral, Borda Coral
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-[#ff6347] hover:border-gray-500 focus:outline-none focus:text-[#ff6347] focus:border-gray-700 transition duration-150 ease-in-out'; // INATIVO: Texto Cinza Claro, Hover para Coral
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
