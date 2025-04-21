@extends('layouts.app')
@section('title', 'Centre de Notifications')
@section('content')
    <div class="mx-auto py-8">
        <div class="flex justify-end">
            <a href="{{ route('recrutements.index') }}"
                class="inline-flex items-center px-4 py-2 bg-[#0A1C3E] text-white font-medium rounded-lg hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:ring-offset-2 transition-all duration-200">
                <i class="fa-regular fa-eye text-[16px] w-6"></i>
                <span>Voir les recrutements</span>
            </a>
        </div>
        <!-- Intégration du composant de recherche -->
        <x-notifications.search-notification :search="request('search')" />
        <div class="bg-white shadow">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm" id="materiels-table">
                    <thead class="text-xs uppercase text-white">
                        <tr class="bg-[#0A1C3E]">
                            <th scope="col" class="px-4 py-3">Nom</th>
                            <th scope="col" class="px-4 py-3">Fonction</th>
                            <th scope="col" class="px-4 py-3">Departement</th>
                            <th scope="col" class="px-4 py-3">Email</th>
                            <th scope="col" class="px-4 py-3">Date d'affectation</th>
                            <th scope="col" class="px-4 py-3">Téléphone</th>
                            <th scope="col" class="px-4 py-3">Modèle</th>
                            <th scope="col" class="px-4 py-3">Type</th>
                            <th scope="col" class="px-4 py-3">N° Série</th>
                            <th scope="col" class="px-4 py-3">Type de Contrat</th>
                            <th scope="col" class="px-4 py-3">Statut</th>
                            <th scope="col" class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $notification)
                            <tr class="border-b hover:bg-gray-50 text-sm">
                                <td class="px-4 py-3 font-medium text-gray-900 uppercase ">
                                    {{ $notification->recrutement ? $notification->recrutement->nom : 'N/A' }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ $notification->recrutement ? $notification->recrutement->fonction : 'N/A' }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ $notification->recrutement ? $notification->recrutement->departement : 'N/A' }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ $notification->recrutement ? $notification->recrutement->email : 'N/A' }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ $notification->recrutement ? $notification->recrutement->date_affectation : 'N/A' }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ $notification->recrutement ? $notification->recrutement->telephone : 'N/A' }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ $notification->recrutement ? $notification->recrutement->model : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex text-nowrap rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800">
                                        {{ $notification->type }}
                                    </span>
                                </td>
                                <td class="px-2 py-1">
                                    {{ $notification->recrutement ? $notification->recrutement->num_serie : 'N/A' }}
                                </td>
                                <td class="px-2 py-1 text-center">
                                    @if ($notification->recrutement)
                                        <span
                                            class="inline-flex items-center text-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $notification->recrutement->type_contrat }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs">N/A</span>
                                    @endif
                                </td>
                                <td class="px-2 py-1 text-center">
                                    @if ($notification->recrutement)
                                        <span
                                            class="inline-flex items-center  rounded-full px-2.5 py-1 text-xs font-medium {{ $notification->recrutement->status === 'validé' ? 'bg-green-100 text-green-800' : 'bg-red-400 text-black' }}">
                                            {{ $notification->recrutement->status }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs">N/A</span>
                                    @endif
                                </td>
                                <td class="px-2 py-1 text-center">
                                    @if ($notification->recrutement && $notification->recrutement->status !== 'validé')
                                        <div class="flex items-center justify-center space-x-3">
                                            <a href="{{ route('notifications.edit', $notification->id) }}"
                                                class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-100 transition-colors"
                                                title="Modifier">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('notifications.valider', $notification->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-100 transition-colors"
                                                    title="Valider"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir valider ce recrutement ?')">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        @if (auth()->user()->role === 'admin')
                                            <form action="{{ route('notifications.destroy', $notification->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-100 transition-colors"
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span
                                                class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800">
                                                Validé
                                            </span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-6 py-6 text-center text-gray-500">
                                    Aucune notification trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 p-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection
