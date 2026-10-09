<button
    type="button"
    @click="$dispatch('abrir-carrito')"
    class="relative inline-flex size-10 items-center justify-center rounded-xl border border-zinc-200 bg-white text-zinc-600 transition hover:border-zinc-300 hover:text-indigo-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:text-indigo-400"
    aria-label="Abrir carrito"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
    </svg>
    @if ($this->cantidad > 0)
        <span class="absolute -right-1.5 -top-1.5 flex size-5 items-center justify-center rounded-full bg-indigo-600 text-[10px] font-bold text-white">
            {{ $this->cantidad > 99 ? '99+' : $this->cantidad }}
        </span>
    @endif
</button>
