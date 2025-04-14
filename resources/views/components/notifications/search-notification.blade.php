@props(['search'])
<div class="mb-6">
    <div class="flex flex-col justify-between md:flex-row items-start md:items-center gap-4">
        <!-- Titre et explications -->
        <div>
            <h1 class="text-xl font-bold text-gray-900">Notifications</h1>
            <p class="text-sm text-gray-500 mt-1">Consultez et gérez les demandes de recrutement</p>
        </div>

        <!-- Champ de recherche -->
        <div class="w-full md:w-1/3">
            <form action="{{ route('notifications.index') }}" method="get" class="relative">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="search" name="search" value="{{ $search ?? '' }}"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] sm:text-sm transition duration-150 ease-in-out"
                        placeholder="Rechercher dans tous les champs (nom, email, fonction, téléphone, numéro série...)">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fonction pour appliquer les filtres
        function applyFilters() {
            const search = document.querySelector('input[name="search"]').value;

            let url = new URL(window.location.href);
            let params = new URLSearchParams(url.search);

            // Mettre à jour ou supprimer les paramètres
            if (search) {
                params.set('search', search);
            } else {
                params.delete('search');
            }

            // Rediriger vers la nouvelle URL
            window.location.href = `${url.pathname}?${params.toString()}`;
        }
    });
</script>
