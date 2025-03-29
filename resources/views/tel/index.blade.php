@extends('layouts.app')

@section('title', 'Liste des téléphones')

@section('content')
    <div>
        <h1 class="header-title">Liste des Téléphones</h1>
        <x-materiels.search-tel search="{{ $search }}" />
        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @elseif (session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        <table class="table">
            <thead>
                <tr class="tr">
                    <th class="pl-2">Modèle</th>
                    <th class="pl-2">Type</th>
                    <th class="pl-2">Numéro de Série</th>
                    <th class="pl-2">État</th>
                    <th class="pl-2">Statut</th>
                    <th class="pl-2">PIN</th>
                    <th class="pl-2">PUK</th>
                    <th class="pl-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($telephones as $telephone)
                    <tr class="border-b border-gray-200 text-sm">
                        <td class="h-[40px]">{{ $telephone->materiel->fabricant }}</td>
                        <td class="h-[40px]">{{ $telephone->materiel->type }}</td>
                        <td class="h-[40px]">{{ $telephone->materiel->num_serie }}</td>
                        <td class="h-[40px]">{{ $telephone->materiel->etat }}</td>

                        <td class="h-[40px]">
                            @if ($telephone->materiel->affectations->isNotEmpty())
                                <span>
                                    {{ $telephone->materiel->affectations->first()->statut }}
                                </span>
                            @else
                                <span class="">NON AFFECTÉ</span>
                            @endif
                        </td>
                        <td class="h-[40px]">{{ $telephone->pin }}</td>
                        <td class="h-[40px]">{{ $telephone->puk }}</td>
                        <td class="h-[40px] flex items-center gap-2 justify-center ">
                            <a href="{{ route('telephones.edit', $telephone->id) }}"><i
                                    class="fa-regular fa-pen-to-square text-blue-700"></i>
                            </a>
                            <form action="{{ route('telephones.destroy', $telephone->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer ce téléphone ?')"> <i
                                        class="fa-solid fa-trash text-red-500"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Aucun téléphone trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
