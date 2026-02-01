@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-50 border-slate-200 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 rounded-xl shadow-sm transition-all duration-200 outline-none']) }}>