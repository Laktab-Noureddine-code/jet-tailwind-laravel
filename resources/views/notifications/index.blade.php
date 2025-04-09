@extends('layouts.app')
@section('title', 'Centre de Notifications')
@section('content')
    <div class="container mx-auto py-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700" role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 px-6 py-5 text-base text-red-700" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="mt-6 bg-white shadow ">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm" id="materiels-table">
                    <thead class="text-xs uppercase text-white">
                        <tr class="bg-[#0A1C3E]">
                            <th scope="col" class="px-4 py-3">Nom</th>
                            <th scope="col" class="px-4 py-3">Fonction</th>
                            <th scope="col" class="px-4 py-3">Departement</th>
                            <th scope="col" class="px-4 py-3">Email</th>
                            <th scope="col" class="px-4 py-3">Téléphone</th>
                            <th scope="col" class="px-4 py-3">Modèle</th>
                            <th scope="col" class="px-4 py-3">Numéro de Série</th>
                            <th scope="col" class="px-4 py-3">Type de Contrat</th>
                            <th scope="col" class="px-4 py-3">Statut</th>
                            <th scope="col" class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $notification)
                            <tr
                                class="border-b hover:bg-gray-50 ">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $notification->recrutement->nom }}</td>
                                <td class="px-4 py-3">{{ $notification->recrutement->fonction }}</td>
                                <td class="px-4 py-3">{{ $notification->recrutement->departement }}</td>
                                <td class="px-4 py-3">{{ $notification->recrutement->email }}</td>
                                <td class="px-4 py-3">{{ $notification->recrutement->telephone }}</td>
                                <td class="px-4 py-3">{{ $notification->recrutement->model }}</td>
                                <td class="px-4 py-3">{{ $notification->recrutement->num_serie }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $notification->recrutement->type_contrat === 'jet' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $notification->recrutement->type_contrat }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center text-nowrap rounded-full px-2.5 py-1 text-xs font-medium {{ $notification->recrutement->status === 'validé' ? 'bg-green-100 text-green-800' : 'bg-red-400 text-black' }}">
                                        {{ $notification->recrutement->status }}
                                    </span>
                                </td>
                                @if ($notification->recrutement->status !== 'validé')
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center space-x-3">
                                            <!-- Bouton Modifier -->
                                            <a href="{{ route('notifications.edit', $notification->id) }}"
                                                class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-100 transition-colors"
                                                title="Modifier">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>

                                            <!-- Bouton Valider -->
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
                                    </td>
                                @else
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800">
                                            Validé
                                        </span>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-6 text-center text-gray-500">
                                    Aucune notification trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
