@props(['search'])
<div class="mb-6">
    <div class="flex flex-col justify-between md:flex-row items-start md:items-center gap-4">
        <!-- Bouton Ajouter un téléphone -->
        <a href="{{ route('telephones.create') }}"
            class="inline-flex items-center px-4 py-2 bg-[#0A1C3E] text-white font-medium rounded-lg hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:ring-offset-2 transition-all duration-200">
            <i class="fas fa-plus mr-2"></i>
            Ajouter un téléphone
        </a>
        <!-- Champ de recherche -->
        <div class="w-full md:w-1/3">
            <form action="{{ route('telephones.index') }}" method="get" class="relative">
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
                        class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] sm:text-sm transition duration-150 ease-in-out"
                        placeholder="Rechercher un téléphone ou un utilisateur...">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilters = document.getElementById('status-filters');
        const radioInputs = statusFilters.querySelectorAll('input[type="radio"]');
        const labels = statusFilters.querySelectorAll('label');

        radioInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Reset all labels to default style
                labels.forEach(label => {
                    label.classList.remove('bg-[#0A1C3E]', 'text-white');
                    label.classList.add('bg-gray-100', 'text-gray-700');
                });

                // Apply active style to selected label
                const selectedLabel = this.closest('label');
                selectedLabel.classList.remove('bg-gray-100', 'text-gray-700');
                selectedLabel.classList.add('bg-[#0A1C3E]', 'text-white');
            });
        });
    });
</script>
