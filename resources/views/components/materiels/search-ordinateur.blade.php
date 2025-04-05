@props(['search'])
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <!-- Bouton Ajouter un ordinateur -->
    <a href="{{ route('ordinateurs.create') }}"
        class="inline-flex items-center px-4 py-2 bg-[#0A1C3E] text-white font-medium rounded-lg hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:ring-offset-2 transition-all duration-200">
        <i class="fas fa-plus mr-2"></i>
        Ajouter un ordinateur
    </a>

    <!-- Filtres de statut -->
    <div class="flex flex-wrap gap-2">
        <label class="inline-flex items-center">
            <input type="radio" name="statut" value="all" checked class="form-radio h-4 w-4 text-[#0A1C3E]">
            <span class="ml-2 text-sm text-gray-700">Tous</span>
        </label>
        <label class="inline-flex items-center">
            <input type="radio" name="statut" value="AFFECTE" class="form-radio h-4 w-4 text-[#0A1C3E]">
            <span class="ml-2 text-sm text-gray-700">Affecté</span>
        </label>
        <label class="inline-flex items-center">
            <input type="radio" name="statut" value="REAFFECTE" class="form-radio h-4 w-4 text-[#0A1C3E]">
            <span class="ml-2 text-sm text-gray-700">Réaffecté</span>
        </label>
        <label class="inline-flex items-center">
            <input type="radio" name="statut" value="NON AFFECTE" class="form-radio h-4 w-4 text-[#0A1C3E]">
            <span class="ml-2 text-sm text-gray-700">Non Affecté</span>
        </label>
    </div>

    <!-- Champ de recherche -->
    <div class="w-full md:w-1/3">
        <form action="{{ route('ordinateurs.index') }}" method="get" class="relative">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="search" name="search" value="{{ $search ? $search : '' }}"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] sm:text-sm transition duration-150 ease-in-out"
                    placeholder="Rechercher un ordinateur...">
                <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <span class="sr-only">Rechercher</span>
                    <svg class="h-5 w-5 text-[#0A1C3E]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
