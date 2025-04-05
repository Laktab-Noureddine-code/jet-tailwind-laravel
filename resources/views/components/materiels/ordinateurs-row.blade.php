@props(['ordinateur'])
<tr class="hover:bg-gray-50 transition-colors duration-150" data-statut="{{ $ordinateur->statut }}">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ordinateur->num_serie }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ordinateur->fabricant }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ordinateur->type }}</td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span
            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
            {{ $ordinateur->statut === 'AFFECTE'
                ? 'bg-green-100 text-green-800'
                : ($ordinateur->statut === 'REAFFECTE'
                    ? 'bg-yellow-100 text-yellow-800'
                    : 'bg-gray-100 text-gray-800') }}">
            {{ $ordinateur->statut }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ordinateur->etat }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ordinateur->processeur }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ordinateur->ram }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $ordinateur->stockage }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <div class="flex items-center space-x-3">
            <a href="{{ route('ordinateurs.edit', $ordinateur->ordinateur_id) }}"
                class="text-[#0A1C3E] hover:text-[#0A1C3E]/80 transition-colors duration-200">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
            <form action="{{ route('ordinateurs.destroy', $ordinateur->ordinateur_id) }}" method="post"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet ordinateur ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-200">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
