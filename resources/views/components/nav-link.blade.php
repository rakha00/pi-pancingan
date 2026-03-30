@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-sm font-bold leading-5 text-indigo-700 dark:text-indigo-400 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2 rounded-xl border border-transparent text-sm font-medium leading-5 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
