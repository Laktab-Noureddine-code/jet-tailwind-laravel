@props(['peripherique'])

<tr class="border-b border-gray-200 text-sm" data-statut="{{ $peripherique->statut }}">
    <td>{{ $peripherique->fabricant }}</td>
    <td>{{ $peripherique->type }}</td>
    <td>{{ $peripherique->statut }}</td>
    <td>{{ $peripherique->num_serie }}</td>
    <td>{{ $peripherique->etat }}</td>
    <td class="flex items-center justify-center">
        <a class="cursor-pointer mx-1" href="{{ route('peripheriques.edit', $peripherique) }}">
            <i class="fa-regular fa-pen-to-square text-blue-700"></i>
        </a>
        <form action="{{ route('peripheriques.destroy', $peripherique) }}" method="post" class="mx-1"
            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce peripherique')">
            @csrf
            @method('DELETE')
            <button class="mr-2 cursor-pointer">
                <i class="fa-solid fa-trash text-red-500"></i>
            </button>
        </form>
    </td>
</tr>