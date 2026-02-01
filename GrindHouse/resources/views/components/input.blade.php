@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 lg:dark:border-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 lg:dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-600 lg:dark:focus:ring-indigo-500 rounded-md shadow-sm bg-white dark:bg-zinc-900 lg:dark:bg-white text-gray-900 dark:text-gray-300 lg:dark:text-gray-900']) !!}>
