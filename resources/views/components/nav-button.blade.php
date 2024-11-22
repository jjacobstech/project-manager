<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 bg-white border border-teal-900 rounded-md font-semibold text-xs text-black text-teal-900 uppercase hover:text-white tracking-widest hover:bg-teal-900 active:bg-gray-500 focus:outline-none transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
