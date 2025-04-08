@props(['affectation'])
<tr class="border-b bg-white hover:bg-gray-50">
    <td class="px-6 py-4 font-medium text-gray-900">
        <div class="flex items-center">
            <div class="ml-4">
                <div class="font-medium text-gray-900">{{ $affectation->utilisateur->nom }}</div>
            </div>
        </div>
    </td>
    {{-- <td>{{ $affectation->utilisateur->fonction }}</td> --}}
    {{-- <td>{{ $affectation->utilisateur->telephone }}</td> --}}
    <td class="px-6 py-4">{{ $affectation->utilisateur->email }}</td>
    {{-- <td>{{ $affectation->utilisateur->departement }}</td> --}}
    {{-- <td>{{ $affectation->chantier }}</td> --}}
    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($affectation->date_affectation)->format('d M Y') }}</td>
    <td class="px-6 py-4">{{ $affectation->materiel ? $affectation->materiel->fabricant : 'N/A' }}</td>
    <td class="px-6 py-4">
        @if ($affectation->materiel)
            <span class="inline-flex rounded-full bg-blue-100 px-2 text-nowrap text-xs font-semibold leading-5 text-blue-800">
                {{ $affectation->materiel->type }}
            </span>
        @else
            <span class="inline-flex rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800">
                N/A
            </span>
        @endif
    </td>
    <td class="px-6 py-4">
        <span
            class="inline-flex rounded-full px-2 text-nowrap text-xs font-semibold leading-5 {{ $affectation->statut === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
            {{ $affectation->statut }}
        </span>
    </td>
    <td class="px-6 py-4 font-medium text-nowrap">{{ $affectation->materiel ? $affectation->materiel->num_serie : 'N/A' }}</td>
    <td class="px-6 py-4">
        @if ($affectation->materiel)
            <span
                class="inline-flex text-nowrap rounded-full px-2 text-xs font-semibold leading-5 {{ $affectation->materiel->etat === 'Neuf' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ $affectation->materiel->etat }}
            </span>
        @else
            <span class="inline-flex text-nowrap rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800">
                N/A
            </span>
        @endif
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center justify-center space-x-3">
            <a href="{{ route('affectation.edit', $affectation) }}" class="text-blue-600 hover:text-blue-900"
                title="Modifier">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>

            <form action="{{ route('affectation.destroy', $affectation) }}" method="post" class="inline-block"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>

            <a href="{{ route('generatePdf', $affectation) }}" class="text-red-600 hover:text-red-900"
                title="Télécharger PDF">
                <i class="fa-solid fa-file-pdf"></i>
            </a>

            <a href="{{ route('affectation.show', $affectation->utilisateur->id) }}"
                class="text-gray-600 hover:text-gray-900" title="Voir les détails">
                <i class="fa-solid fa-eye"></i>
            </a>
        </div>
    </td>
</tr>
