@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-teal-400 dark:border-teal-600 text-start text-base font-medium text-teal-900 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/50 focus:outline-none focus:text-gray-800 dark:focus:text-teal-200 focus:bg-teal-100 dark:focus:bg-teal-900 focus:border-teal-700 dark:focus:border-teal-300 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-teal-900 hover:bg-white hover:border-white focus:outline-none focus:text-white focus:bg-white focus:border-white
       transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
