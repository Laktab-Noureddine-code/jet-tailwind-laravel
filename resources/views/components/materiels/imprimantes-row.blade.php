@props(['imprimante'])
<tr class="border-b text-sm bg-white hover:bg-gray-50" data-statut="{{ $imprimante->statut }}">
    <td class="px-2 py-2 font-medium text-gray-900">{{ $imprimante->num_serie }}</td>
    <td class="px-2 py-2 font-medium text-gray-900">{{ $imprimante->num_commande }}</td>
    <td class="px-2 py-2">{{ $imprimante->fabricant }}</td>
    <td class="px-2 py-2">{{ $imprimante->utilisateur_nom }}</td>
    <td class="px-2 py-2">
        <span
            class="inline-flex rounded-full text-nowrap px-2 text-xs font-semibold leading-5 
            {{ $imprimante->statut === 'AFFECTE'
                ? 'bg-green-100 text-green-800'
                : ($imprimante->statut === 'REAFFECTE'
                    ? 'bg-yellow-100 text-yellow-800'
                    : 'bg-gray-100 text-gray-800') }}">
            {{ $imprimante->statut }}
        </span>
    </td>
    <td class="px-2 py-2">
        <span
            class="inline-flex rounded-full px-2 text-xs text-nowrap font-semibold leading-5 
            {{ $imprimante->etat === 'Neuf' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
            {{ $imprimante->etat }}
        </span>
    </td>

    <td class="px-2 py-2">
        @if ($imprimante->identifiant_noir)
            <div class="flex flex-col">
                <span>{{ $imprimante->identifiant_noir }}</span>
                <span
                    class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-black text-white">
                    {{ $imprimante->toner_noir ?? '0' }}
                </span>
            </div>
        @endif
    </td>
    <td class="px-2 py-2">
        @if ($imprimante->identifiant_bleu)
            <div class="flex flex-col">
                <span>{{ $imprimante->identifiant_bleu }}</span>
                <span
                    class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-500 text-white">
                    {{ $imprimante->toner_bleu ?? '0' }}
                </span>
            </div>
        @endif
    </td>
    <td class="px-2 py-2">
        @if ($imprimante->identifiant_magenta)
            <div class="flex flex-col">
                <span>{{ $imprimante->identifiant_magenta }}</span>
                <span
                    class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-pink-500 text-white">
                    {{ $imprimante->toner_magenta ?? '0' }}
                </span>
            </div>
        @endif
    </td>
    <td class="px-2 py-2">
        @if ($imprimante->identifiant_jaune)
            <div class="flex flex-col">
                <span>{{ $imprimante->identifiant_jaune }}</span>
                <span
                    class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-yellow-500 text-white">
                    {{ $imprimante->toner_jaune ?? '0' }}
                </span>
            </div>
        @endif
    </td>
    <td class="px-2 py-2">
        <div class="flex items-center justify-center space-x-3">
            <a href="{{ route('imprimantes.edit', $imprimante->materiel_id) }}"
                class="text-blue-600 hover:text-blue-900" title="Modifier">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
            <form action="{{ route('imprimantes.destroy', $imprimante->materiel_id) }}" method="post"
                class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette imprimante ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>

            @if ($imprimante->ip_adresse)
                <a href="{{ $imprimante->ip_adresse }}" target="_blank" class="text-sm" title="go to printer"
                    class="text-blue-600 hover:text-blue-900">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            @endif

        </div>
    </td>
</tr>
