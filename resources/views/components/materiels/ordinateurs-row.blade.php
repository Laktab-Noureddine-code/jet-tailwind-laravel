@props(['ordinateur'])
<tr class="border-b bg-white hover:bg-gray-50" data-statut="{{ $ordinateur->statut }}">
    <td class="px-6 py-4 font-medium text-gray-900">{{ $ordinateur->num_serie }}</td>
    <td class="px-6 py-4">{{ $ordinateur->fabricant }}</td>
    <td class="px-6 py-4">
        <span class="inline-flex text-nowrap rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800">
            {{ $ordinateur->type }}
        </span>
    </td>
    <td class="px-6 py-4">
        <span
            class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
            {{ $ordinateur->statut === 'AFFECTE'
                ? 'bg-green-100 text-green-800'
                : ($ordinateur->statut === 'REAFFECTE'
                    ? 'bg-yellow-100 text-yellow-800'
                    : 'bg-gray-100 text-gray-800') }}">
            {{ $ordinateur->statut }}
        </span>
    </td>
    <td class="px-6 py-4">
        <span
            class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
            {{ $ordinateur->etat === 'Neuf' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
            {{ $ordinateur->etat }}
        </span>
    </td>
    <td class="px-6 py-4">{{ $ordinateur->processeur }}</td>
    <td class="px-6 py-4">{{ $ordinateur->ram }}</td>
    <td class="px-6 py-4">{{ $ordinateur->stockage }}</td>
    <td class="px-6 py-4">
        <div class="flex items-center justify-center space-x-3">
            <a href="{{ route('ordinateurs.edit', $ordinateur->ordinateur_id) }}"
                class="text-blue-600 hover:text-blue-900" title="Modifier">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
            <form action="{{ route('ordinateurs.destroy', $ordinateur->ordinateur_id) }}" method="post"
                class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet ordinateur ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
