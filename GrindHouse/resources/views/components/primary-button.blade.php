<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-600 to-amber-700 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:from-amber-700 hover:to-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 active:from-amber-800 active:to-amber-900 transition-all duration-200 ease-in-out shadow-lg hover:shadow-xl']) }}>
    {{ $slot }}
</button>
