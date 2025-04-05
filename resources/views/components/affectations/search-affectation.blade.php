<div class="flex items-center justify-between gap-4">
    <div class="flex-1 max-w-2xl">
        <form action="{{ route('affectation.index') }}" method="get">
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="search" name="search"
                    class="block w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Rechercher une affectation..." value="{{ $search }}">
            </div>
        </form>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('affectation.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-[#FFD700] px-4 py-2.5 text-sm font-semibold text-gray-900 hover:bg-[#FFD700]/90 focus:outline-none focus:ring-2 focus:ring-[#FFD700]/50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nouvelle Affectation
        </a>
    </div>
</div>
