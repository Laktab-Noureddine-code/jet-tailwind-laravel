@props(['affectation'])
<tr class="border-b border-gray-200 text-sm">
    <td>{{ $affectation->utilisateur->nom }}</td>
    {{-- <td>{{ $affectation->utilisateur->fonction }}</td> --}}
    {{-- <td>{{ $affectation->utilisateur->telephone }}</td> --}}
    <td>{{ $affectation->utilisateur->email }}</td>
    {{-- <td>{{ $affectation->utilisateur->departement }}</td> --}}
    {{-- <td>{{ $affectation->chantier }}</td> --}}
    <td>{{ $affectation->date_affectation }}</td>
    <td>{{ $affectation->materiel->fabricant }}</td>
    <td>{{ $affectation->materiel->type }}</td>
    <td>{{ $affectation->statut }}</td>
    <td>{{ $affectation->materiel->num_serie }}</td>
    <td>{{ $affectation->materiel->etat }}</td>
    <td class="flex items-center justify-center">
        <a class="cursor-pointer  mx-1 " href="{{ route('affectation.edit', $affectation) }}">
            <i class="fa-regular fa-pen-to-square text-blue-700"></i>
        </a>
        <form action="{{ route('affectation.destroy', $affectation) }}" method="post" class=" mx-1"
            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation')">
            @csrf
            @method('DELETE')
            <button class="mr-2 cursor-pointer">
                <i class="fa-solid fa-trash text-red-400"></i>
            </button>
        </form>
        <a href="{{route('generatePdf' ,$affectation)}}" class=" mx-1">
            <i class="fa-solid fa-file-pdf text-red-700"></i>
        </a>
        <a href="{{route('affectation.show' ,$affectation->utilisateur->id)}}" class=" mx-1">
            <i class="fa-solid fa-eye"></i>
        </a>
    </td>
</tr>
