@extends('layouts.app')

@section('title', 'Gestion de la Corbeille')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Corbeille</h1>
        </div>

        <!-- Affectations -->
        @if ($affectations->isNotEmpty())
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Affectations supprimées</h2>
                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="text-xs uppercase text-white">
                                <tr class="bg-[#0A1C3E]">
                                    <th scope="col" class="px-6 py-4">Utilisateur</th>
                                    <th scope="col" class="px-6 py-4">Matériel</th>
                                    <th scope="col" class="px-6 py-4">Numéro de série</th>
                                    <th scope="col" class="px-6 py-4">Date d'affectation</th>
                                    <th scope="col" class="px-6 py-4">Chantier</th>
                                    <th scope="col" class="px-6 py-4">Utilisateur</th>
                                    <th scope="col" class="px-6 py-4">Date de suppression</th>
                                    <th scope="col" class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($affectations as $affectation)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            @if ($affectation->utilisateur && $affectation->utilisateur->exists)
                                                {{ $affectation->utilisateur->nom }}
                                            @else
                                                <span class="text-gray-400">Utilisateur supprimé</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($affectation->materiel && $affectation->materiel->exists)
                                                {{ $affectation->materiel->type }}
                                            @else
                                                <span class="text-gray-400">Matériel supprimé</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($affectation->materiel && $affectation->materiel->exists)
                                                {{ $affectation->materiel->num_serie }}
                                            @else
                                                <span class="text-gray-400"></span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $affectation->date_affectation }}</td>
                                        <td class="px-6 py-4">{{ $affectation->chantier }}</td>
                                        <td class="px-6 py-4">{{ $affectation->utilisateur1 }}</td>
                                        <td class="px-6 py-4">
                                            {{ $affectation->deleted_at ? $affectation->deleted_at->setTimezone('Africa/Casablanca')->format('Y-m-d H:i:s') : '' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form
                                                action="{{ route('trash.forceDelete', ['type' => 'affectation', 'id' => $affectation->id]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette affectation ?')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Ordinateurs -->
        @if ($ordinateurs->isNotEmpty())
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Ordinateurs supprimés</h2>
                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="text-xs uppercase text-white">
                                <tr class="bg-[#0A1C3E]">
                                    <th scope="col" class="px-6 py-4">Numéro de série</th>
                                    <th scope="col" class="px-6 py-4">Fabricant</th>
                                    <th scope="col" class="px-6 py-4">RAM</th>
                                    <th scope="col" class="px-6 py-4">Stockage</th>
                                    <th scope="col" class="px-6 py-4">Processeur</th>
                                    <th scope="col" class="px-6 py-4">Date de suppression</th>
                                    <th scope="col" class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ordinateurs as $ordinateur)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $ordinateur->materiel->num_serie }}</td>
                                        <td class="px-6 py-4">{{ $ordinateur->materiel->fabricant }}</td>
                                        <td class="px-6 py-4">{{ $ordinateur->ram }}</td>
                                        <td class="px-6 py-4">{{ $ordinateur->stockage }}</td>
                                        <td class="px-6 py-4">{{ $ordinateur->processeur }}</td>
                                        <td class="px-6 py-4">
                                            {{ $ordinateur->deleted_at ? $ordinateur->deleted_at->setTimezone('Africa/Casablanca')->format('Y-m-d H:i:s') : '' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form
                                                action="{{ route('trash.forceDelete', ['type' => 'ordinateur', 'id' => $ordinateur->id]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet ordinateur ?')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Imprimantes -->
        @if ($imprimantes->isNotEmpty())
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Imprimantes supprimées</h2>
                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="text-xs uppercase text-white">
                                <tr class="bg-[#0A1C3E]">
                                    <th scope="col" class="px-6 py-4">Numéro de série</th>
                                    <th scope="col" class="px-6 py-4">Fabricant</th>
                                    <th scope="col" class="px-6 py-4">État</th>
                                    <th scope="col" class="px-6 py-4">Toner Noir</th>
                                    <th scope="col" class="px-6 py-4">Toner Bleu</th>
                                    <th scope="col" class="px-6 py-4">Toner Magenta</th>
                                    <th scope="col" class="px-6 py-4">Toner Jaune</th>
                                    <th scope="col" class="px-6 py-4">Date de suppression</th>
                                    <th scope="col" class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($imprimantes as $imprimante)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $imprimante->materiel->num_serie }}</td>
                                        <td class="px-6 py-4">{{ $imprimante->materiel->fabricant }}</td>
                                        <td class="px-6 py-4">{{ $imprimante->materiel->etat }}</td>
                                        <td class="px-6 py-4">
                                            @if ($imprimante->identifiant_noir)
                                                <div class="flex flex-col">
                                                    <span>{{ $imprimante->identifiant_noir }}</span>
                                                    <span
                                                        class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-black text-white">
                                                        {{ $imprimante->toner_noir ?? '0' }}
                                                    </span>
                                                </div>
                                            @else
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($imprimante->identifiant_bleu)
                                                <div class="flex flex-col">
                                                    <span>{{ $imprimante->identifiant_bleu }}</span>
                                                    <span
                                                        class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-500 text-white">
                                                        {{ $imprimante->toner_bleu ?? '0' }}
                                                    </span>
                                                </div>
                                            @else
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($imprimante->identifiant_magenta)
                                                <div class="flex flex-col">
                                                    <span>{{ $imprimante->identifiant_magenta }}</span>
                                                    <span
                                                        class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-pink-500 text-white">
                                                        {{ $imprimante->toner_magenta ?? '0' }}
                                                    </span>
                                                </div>
                                            @else
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($imprimante->identifiant_jaune)
                                                <div class="flex flex-col">
                                                    <span>{{ $imprimante->identifiant_jaune }}</span>
                                                    <span
                                                        class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-yellow-500 text-white">
                                                        {{ $imprimante->toner_jaune ?? '0' }}
                                                    </span>
                                                </div>
                                            @else
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $imprimante->deleted_at ? $imprimante->deleted_at->setTimezone('Africa/Casablanca')->format('Y-m-d H:i:s') : '' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form
                                                action="{{ route('trash.forceDelete', ['type' => 'imprimante', 'id' => $imprimante->id]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette imprimante ?')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Téléphones -->
        @if ($telephones->isNotEmpty())
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Téléphones supprimés</h2>
                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="text-xs uppercase text-white">
                                <tr class="bg-[#0A1C3E]">
                                    <th scope="col" class="px-6 py-4">Numéro de série</th>
                                    <th scope="col" class="px-6 py-4">Fabricant</th>
                                    <th scope="col" class="px-6 py-4">PIN</th>
                                    <th scope="col" class="px-6 py-4">PUK</th>
                                    <th scope="col" class="px-6 py-4">Utilisateur</th>
                                    <th scope="col" class="px-6 py-4">Date de suppression</th>
                                    <th scope="col" class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($telephones as $telephone)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $telephone->materiel->num_serie }}</td>
                                        <td class="px-6 py-4">{{ $telephone->materiel->fabricant }}</td>
                                        <td class="px-6 py-4">{{ $telephone->pin }}</td>
                                        <td class="px-6 py-4">{{ $telephone->puk }}</td>
                                        <td class="px-6 py-4">
                                            @if ($telephone->materiel->affectations->isNotEmpty() && $telephone->materiel->affectations->first()->utilisateur)
                                                {{ $telephone->materiel->affectations->first()->utilisateur->nom }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $telephone->deleted_at ? $telephone->deleted_at->setTimezone('Africa/Casablanca')->format('Y-m-d H:i:s') : '' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form
                                                action="{{ route('trash.forceDelete', ['type' => 'telephone', 'id' => $telephone->id]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce téléphone ?')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Périphériques -->
        @if ($peripheriques->isNotEmpty())
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Périphériques supprimés</h2>
                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="text-xs uppercase text-white">
                                <tr class="bg-[#0A1C3E]">
                                    <th scope="col" class="px-6 py-4">Numéro de série</th>
                                    <th scope="col" class="px-6 py-4">Fabricant</th>
                                    <th scope="col" class="px-6 py-4">Type</th>
                                    <th scope="col" class="px-6 py-4">État</th>
                                    <th scope="col" class="px-6 py-4">Date de suppression</th>
                                    <th scope="col" class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peripheriques as $peripherique)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $peripherique->num_serie }}</td>
                                        <td class="px-6 py-4">{{ $peripherique->fabricant }}</td>
                                        <td class="px-6 py-4">{{ $peripherique->type }}</td>
                                        <td class="px-6 py-4">{{ $peripherique->etat }}</td>
                                        <td class="px-6 py-4">
                                            {{ $peripherique->deleted_at ? $peripherique->deleted_at->setTimezone('Africa/Casablanca')->format('Y-m-d H:i:s') : '' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form
                                                action="{{ route('trash.forceDelete', ['type' => 'peripherique', 'id' => $peripherique->id]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce périphérique ?')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recrutements -->
        @if ($recrutements->isNotEmpty())
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Recrutements supprimés</h2>
                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="text-xs uppercase text-white">
                                <tr class="bg-[#0A1C3E]">
                                    <th scope="col" class="px-6 py-4">Nom</th>
                                    <th scope="col" class="px-6 py-4">Email</th>
                                    <th scope="col" class="px-6 py-4">Fonction</th>
                                    <th scope="col" class="px-6 py-4">Date de suppression</th>
                                    <th scope="col" class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recrutements as $recrutement)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $recrutement->nom }}</td>
                                        <td class="px-6 py-4">{{ $recrutement->email }}</td>
                                        <td class="px-6 py-4">{{ $recrutement->fonction }}</td>
                                        <td class="px-6 py-4">
                                            {{ $recrutement->deleted_at ? $recrutement->deleted_at->setTimezone('Africa/Casablanca')->format('Y-m-d H:i:s') : '' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form
                                                action="{{ route('trash.forceDelete', ['type' => 'recrutement', 'id' => $recrutement->id]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce recrutement ?')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Notifications -->
        @if ($notifications->isNotEmpty())
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Notifications supprimées</h2>
                <div class="bg-white rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="text-xs uppercase text-white">
                                <tr class="bg-[#0A1C3E]">
                                    <th scope="col" class="px-6 py-4">Type</th>
                                    <th scope="col" class="px-6 py-4">État</th>
                                    <th scope="col" class="px-6 py-4">Date d'affectation</th>
                                    <th scope="col" class="px-6 py-4">Chantier</th>
                                    <th scope="col" class="px-6 py-4">Utilisateur</th>
                                    <th scope="col" class="px-6 py-4">Date de suppression</th>
                                    <th scope="col" class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $notification->type }}</td>
                                        <td class="px-6 py-4">{{ $notification->etat }}</td>
                                        <td class="px-6 py-4">{{ $notification->date_affectation }}</td>
                                        <td class="px-6 py-4">{{ $notification->chantier }}</td>
                                        <td class="px-6 py-4">{{ $notification->utilisateur }}</td>
                                        <td class="px-6 py-4">
                                            {{ $notification->deleted_at ? $notification->deleted_at->setTimezone('Africa/Casablanca')->format('Y-m-d H:i:s') : '' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form
                                                action="{{ route('trash.forceDelete', ['type' => 'notification', 'id' => $notification->id]) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette notification ?')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if (
            $affectations->isEmpty() &&
                $ordinateurs->isEmpty() &&
                $imprimantes->isEmpty() &&
                $telephones->isEmpty() &&
                $peripheriques->isEmpty() &&
                $recrutements->isEmpty() &&
                $notifications->isEmpty())
            <div class="mt-6 bg-white rounded-lg shadow p-6 text-center text-gray-500">
                Aucun élément supprimé trouvé.
            </div>
        @endif
    </div>
@endsection
