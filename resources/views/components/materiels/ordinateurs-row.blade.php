@props(['ordinateur'])
<tr class="border-b border-gray-200 text-sm" data-statut="{{ $ordinateur->statut }}">
    <td>{{ $ordinateur->num_serie }}</td>
    <td>{{ $ordinateur->fabricant }}</td>
    <td>{{ $ordinateur->type }}</td>
    <td>{{ $ordinateur->statut }}</td>
    <td>{{ $ordinateur->etat }}</td>
    <td>{{ $ordinateur->processeur }}</td>
    <td>{{ $ordinateur->ram }}</td>
    <td>{{ $ordinateur->stockage }}</td>

    <td class="flex items-center justify-center">
        <a class="cursor-pointer mx-1" href="{{ route('ordinateurs.edit', $ordinateur->ordinateur_id) }}">
            <i class="fa-regular fa-pen-to-square text-blue-700"></i>
        </a>
        <form action="{{ route('ordinateurs.destroy', $ordinateur->ordinateur_id) }}" method="post" class="mx-1"
            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet ordinateur ?')">
            @csrf
            @method('DELETE')
            <button class="mr-2 cursor-pointer">
                <i class="fa-solid fa-trash text-red-500"></i>
            </button>
        </form>
    </td>
</tr>
