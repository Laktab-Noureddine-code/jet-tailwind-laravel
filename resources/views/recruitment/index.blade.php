@extends('layouts.app')

@section('title', 'Liste des Recrutements')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Liste des Recrutements</h1>
        </div>
        <x-recruitment.search-recruitment :search="request('search')" />

        <div class="mt-6 bg-white shadow">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500" id="materiels-table">
                    <thead class="text-xs uppercase text-white">
                        <tr class="bg-[#0A1C3E]">
                            <th scope="col" class="px-2 py-2">Nom</th>
                            <th scope="col" class="px-2 py-2">Email</th>
                            <th scope="col" class="px-2 py-2">Fonction</th>
                            <th scope="col" class="px-2 py-2">Type de Contrat</th>
                            <th scope="col" class="px-2 py-2">Téléphone</th>
                            <th scope="col" class="px-2 py-2">Modèle</th>
                            <th scope="col" class="px-2 py-2">Numéro de Série</th>
                            <th scope="col" class="px-2 py-2">Date d'affectation</th>
                            <th scope="col" class="px-2 py-2">Puk</th>
                            <th scope="col" class="px-2 py-2">Pin</th>
                            <th scope="col" class="px-2 py-2">Statut</th>
                            <th scope="col" class="px-2 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recrutements as $recrutement)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-2 py-2 uppercase font-semibold">{{ $recrutement->nom }}</td>
                                <td class="px-2 py-2">{{ $recrutement->email }}</td>
                                <td class="px-2 py-2">{{ $recrutement->fonction }}</td>
                                <td class="px-2 py-2">
                                    <span
                                        class="inline-flex items-center text-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $recrutement->type_contrat }}
                                    </span>
                                </td>
                                <td class="px-2 py-2">{{ $recrutement->telephone }}</td>
                                <td class="px-2 py-2">{{ $recrutement->model }}</td>
                                <td class="px-2 py-2">{{ $recrutement->num_serie }}</td>
                                <td class="px-2 py-2">{{ $recrutement->date_affectation }}</td>
                                <td class="px-2 py-2">{{ $recrutement->puk }}</td>
                                <td class="px-2 py-2">{{ $recrutement->pin }}</td>
                                <td class="px-2 py-2">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $recrutement->status === 'validé' ? 'bg-green-100 text-green-800' : 'bg-red-400 text-black' }}">
                                        {{ $recrutement->status }}
                                    </span>
                                </td>
                                @if ($recrutement->status !== 'validé')
                                    <td class="px-2 py-2 text-center">
                                        <div class="flex items-center justify-center space-x-3">
                                            <a href="{{ route('recrutements.edit', $recrutement) }}" class="text-blue-600">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('recrutements.destroy', $recrutement) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600"
                                                    onclick="return confirm('Êtes-vous sûr ?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @else
                                    <td class="px-2 py-2 text-center">

                                        <form action="{{ route('recrutements.destroy', $recrutement) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce recrutement validé ?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="px-6 py-4 text-center text-gray-500">
                                    Aucun recrutement trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 p-4">
                {{ $recrutements->links() }}
            </div>
        </div>
    </div>
@endsection
