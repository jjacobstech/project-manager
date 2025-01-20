<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-white border border-teal-900 rounded-md font-semibold text-xs text-black dark:text-teal-800 uppercase hover:text-white tracking-widest hover:bg-teal-700 dark:hover:bg-white focus:bg-teal-700 dark:focus:bg-white active:bg-teal-900 dark:active:bg-teal-300 focus:outline-none focus:ring-0 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-teal-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
