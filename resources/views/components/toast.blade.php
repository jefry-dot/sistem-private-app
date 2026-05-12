@if (session()->has('success') || session()->has('error') || session()->has('status'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4"
        class="fixed bottom-12 right-6 z-[200] max-w-sm w-full"
    >
        @php
            $isError = session()->has('error');
            $message = session('success') ?? session('error') ?? session('status');
        @endphp

        <div class="p-4 rounded-2xl shadow-2xl border flex items-center gap-4 {{ $isError ? 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/30 dark:border-red-800 dark:text-red-300' : 'bg-white border-gray-100 text-gray-800 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $isError ? 'bg-red-100 dark:bg-red-900/50' : 'bg-emerald-50 dark:bg-emerald-900/50' }}">
                @if($isError)
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                @else
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                @endif
            </div>
            <div class="flex-1">
                <p class="text-xs font-bold uppercase tracking-wider opacity-60 mb-0.5">{{ $isError ? 'Gagal' : 'Berhasil' }}</p>
                <p class="text-sm font-medium leading-tight">{{ $message }}</p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
@endif
