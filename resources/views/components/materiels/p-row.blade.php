@props(['peripherique'])

<tr class="border-b bg-white hover:bg-gray-50 min-h-[40px]" data-statut="{{ $peripherique->statut }}">
    <td class="px-6 py-4 font-medium text-gray-900">{{ $peripherique->num_serie }}</td>
    <td class="px-6 py-4 font-medium text-gray-900">{{ $peripherique->num_commande }}</td>
    <td class="px-6 py-4">{{ $peripherique->fabricant }}</td>
    <td class="px-6 py-4">
        <span
            class="inline-flex text-nowrap rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800">
            {{ $peripherique->type }}
        </span>
    </td>
    <td class="px-6 py-4">
        <span
            class="inline-flex rounded-full text-nowrap px-2 text-xs font-semibold leading-5 
            {{ $peripherique->statut === 'AFFECTE'
                ? 'bg-green-100 text-green-800'
                : ($peripherique->statut === 'REAFFECTE'
                    ? 'bg-yellow-100 text-yellow-800'
                    : 'bg-gray-100 text-gray-800') }}">
            {{ $peripherique->statut }}
        </span>
    </td>
    <td class="px-6 py-4">
        <span
            class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
            {{ $peripherique->etat === 'Neuf' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
            {{ $peripherique->etat }}
        </span>
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center justify-center space-x-3">
            <a href="{{ route('peripheriques.edit', $peripherique) }}" class="text-blue-600 hover:text-blue-900"
                title="Modifier">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
            <form action="{{ route('peripheriques.destroy', $peripherique) }}" method="post" class="inline-block"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce périphérique ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
