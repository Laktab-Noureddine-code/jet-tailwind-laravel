@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
    <div>
        <h1 class="header-title">Notifications</h1>
        @if (session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif
        <table class="table">
            <thead>
                <tr class="tr ">
                    <th class="pl-2">Nom</th>
                    <th class="pl-2">Fonction</th>
                    <th class="pl-2">Departement</th>
                    <th class="pl-2">Email</th>
                    <th class="pl-2">Téléphone</th>
                    <th class="pl-2">Modèle</th>
                    <th class="pl-2">Numéro de Série</th>
                    <th class="pl-2">Puk</th>
                    <th class="pl-2">Pin</th>
                    <th class="pl-2">Type de Contrat</th>
                    <th class="pl-2">Statut</th>
                    <th class="pl-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notifications as $notification)
                    <tr class="border-b border-gray-200 text-sm">
                        <td class="h-[40px]">{{ $notification->recrutement->nom }}</td>
                        <td class="h-[40px]">{{ $notification->recrutement->fonction }}</td>
                        <td class="h-[40px]">{{ $notification->recrutement->departement }}</td>
                        <td class="h-[40px]">{{ $notification->recrutement->email }}</td>
                        <td class="h-[40px]">{{ $notification->recrutement->telephone }}</td>
                        <td class="h-[40px]">{{ $notification->recrutement->model }}</td>
                        <td class="h-[40px]">{{ $notification->recrutement->num_serie }}</td>
                        <td class="h-[40px]">{{ $notification->recrutement->puk }}</td>
                        <td class="h-[40px]">{{ $notification->recrutement->pin }}</td>
                        <td class="h-[40px]">{{ $notification->recrutement->type_contrat }}</td>
                        <td>
                            <span
                                class="text-nowrap {{ $notification->recrutement->status === 'validé' ? 'bg-green-500 px-2 py-1 rounded-lg text-white font-semibold' : 'bg-red-500 px-2 py-1 rounded-lg text-white font-semibold' }}">
                                {{ $notification->recrutement->status }}
                            </span>

                        </td>
                        @if ($notification->recrutement->status !== 'validé')
                            <td class="flex items-center gap-2">
                                <!-- Bouton Modifier -->
                                <a href="{{ route('notifications.edit', $notification->id) }}"
                                    class="text-lg text-blue-900"><i class="fa-solid fa-pen-to-square"></i></a>

                                <!-- Bouton Valider -->
                                <form action="{{ route('notifications.valider', $notification->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="text-green-700 font-bold text-2xl cursor-pointer" onclick="return confirm('Êtes-vous sûr ?')"><i
                                            class="fa-solid fa-check"></i></button>
                                </form>
                            </td>
                        @else
                            <td>
                                <span class="bg-green-500 px-2 py-1 rounded-lg text-white font-semibold">Validé</span>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-4">Aucun notification trouvé.</td>

                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
