@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-slate-700 bg-slate-950/70 text-slate-100 focus:border-blue-400 focus:ring-blue-400 rounded-md shadow-sm']) }}>
