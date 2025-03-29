@props(['search'])
<div class="flex justify-between items-center my-4">
    <!-- Bouton Ajouter une affectation -->
    <div class="">
    </div>
    <!-- Champ de recherche -->
    <div class="w-[40%]">
        <form class="w-full" action="{{ route('telephones.index') }}" method="get">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <div class="flex gap-2">
                    <input type="search" id="default-search" name="search"
                        class="block w-full p-1 ps-10 text-lg text-gray-900 border border-gray-300 rounded-lg bg-white
                               focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Rechercher ..." value="{{ $search ? $search : '' }}" />
                    <button type="submit"
                        class="text-gray-800 cursor-pointer  bg-[#f4d103]
                               focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg
                               text-sm px-4 py-2 hover:bg-[#f4c003]">
                        Rechercher
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script></script>
</div>
