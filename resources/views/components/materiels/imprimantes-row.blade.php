@props(['imprimante'])
<tr class="border-b border-gray-200 text-sm" data-statut="{{ $imprimante->statut }}">
    <td>{{ $imprimante->fabricant }}</td>
    <td>{{ $imprimante->num_serie }}</td>
    <td>{{ $imprimante->utilisateur_nom }}</td>
    <td>{{ $imprimante->statut }}</td>
    <td>{{ $imprimante->etat }}</td>
    <td class="border border-gray-300">
        <div class="flex items-center justify-between p-1">
            <p>{{ $imprimante->identifiant_noir }}</p>
            <div class="p-2 border border-gray-200 rounded-full size-[30px] font-bold flex items-center justify-center {{ $imprimante->toner_noir === 0 ? "bg-red-400" : ''}}">{{ $imprimante->toner_noir }}
            </div>
        </div>
    </td>
    <td class="border border-gray-300">
        <div class="flex items-center justify-between p-1">
            <p>{{ $imprimante->identifiant_bleu }}</p>
            <div class="p-2 border border-gray-200 rounded-full size-[30px] font-bold flex items-center justify-center {{ $imprimante->toner_bleu === 0 ? "bg-red-400" : ''}}">{{ $imprimante->toner_bleu }}
            </div>
        </div>
    </td>
    <td class="border border-gray-300">
        <div class="flex items-center justify-between p-1">
            <p>{{ $imprimante->identifiant_magenta }}</p>
            <div class="p-2 border border-gray-200 rounded-full size-[30px] font-bold flex items-center justify-center {{ $imprimante->toner_magenta === 0 ? "bg-red-400" : ''}}">
                {{ $imprimante->toner_magenta }}</div>
        </div>
    </td>
    <td class="border border-gray-300">
        <div class="flex items-center justify-between p-1">
            <p>{{ $imprimante->identifiant_jaune }}</p>
            <div class="p-2 border border-gray-200 rounded-full size-[30px] font-bold flex items-center justify-center {{ $imprimante->toner_jaune === 0 ? "bg-red-400" : ''}}">{{ $imprimante->toner_jaune  }}
            </div>
        </div>
    </td>

    <td class="flex items-center justify-center">
        <a class="cursor-pointer  mx-1" href="{{ route('imprimantes.edit', $imprimante->materiel_id) }}">
            <i class="fa-regular fa-pen-to-square text-blue-700"></i>
        </a>
        <form action="{{ route('imprimantes.destroy', $imprimante->materiel_id) }}" method="post" class="mx-1"
            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce imprimante')">
            @csrf
            @method('DELETE')
            <button class="cursor-pointer">
                <i class="fa-solid fa-trash text-red-500"></i>
            </button>
        </form>
    </td>
</tr>
