<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des Recrutements</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-[#f6f7f9]">
    <div class="p-3">
        <div class="py-6 relative">
            <h1 class="text-center text-3xl font-bold">Liste des Recrutements</h1>
            <form action="{{ route('logout') }}" method="post" class="absolute right-2 top-[50%] translate-y-[-50%]">
                @csrf
                <button class="cursor-pointer font-semibold text-red-500">
                    Se déconnecter
                    <i class="text-[16px] fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
        <a href="{{ route('recrutements.create') }}"
            class="px-5 py-2 text-[16px] font-semibold rounded-lg bg-sky-950 text-white">Créer un Recrutement</a>

        <div class="mt-6 bg-white rounded-lg shadow">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500" id="materiels-table">
                    @if (session('success'))
                        <div class="message">{{ session('success') }}</div>
                    @endif
                    <thead class="text-xs uppercase text-white">
                        <tr class="bg-[#0A1C3E]">
                            <th scope="col" class="px-2 py-2">Nom</th>
                            <th scope="col" class="px-2 py-2">Email</th>
                            <th scope="col" class="px-2 py-2">Fonction</th>
                            <th scope="col" class="px-2 py-2">Type de Contrat</th>
                            <th scope="col" class="px-2 py-2">Téléphone</th>
                            <th scope="col" class="px-2 py-2">Modèle</th>
                            <th scope="col" class="px-2 py-2">Numéro de Série</th>
                            <th scope="col" class="px-2 py-2">Puk</th>
                            <th scope="col" class="px-2 py-2">Pin</th>
                            <th scope="col" class="px-2 py-2">Statut</th>
                            <th scope="col" class="px-2 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recrutements as $recrutement)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-2 py-2">{{ $recrutement->nom }}</td>
                                <td class="px-2 py-2">{{ $recrutement->email }}</td>
                                <td class="px-2 py-2">{{ $recrutement->fonction }}</td>
                                <td class="px-2 py-2">{{ $recrutement->type_contrat }}</td>
                                <td class="px-2 py-2">{{ $recrutement->telephone }}</td>
                                <td class="px-2 py-2">{{ $recrutement->model }}</td>
                                <td class="px-2 py-2">{{ $recrutement->num_serie }}</td>
                                <td class="px-2 py-2">{{ $recrutement->puk }}</td>
                                <td class="px-2 py-2">{{ $recrutement->pin }}</td>
                                <td class="px-2 py-2">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $recrutement->status === 'validé' ? 'bg-green-100 text-green-800' : 'bg-red-400 text-black' }}">
                                        {{ $recrutement->status }}
                                    </span>
                                </td>
                                @if ($recrutement->status !== 'validé')
                                    <td class="px-2 py-2 text-center">
                                        <div class="flex items-center justify-center space-x-3">
                                            <a href="{{ route('recrutements.edit', $recrutement) }}"
                                                class="text-blue-600">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('recrutements.destroy', $recrutement) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600"
                                                    onclick="return confirm('Êtes-vous sûr ?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @else
                                    <td class="px-2 py-2 text-center">
                                        <span
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800">
                                            Validé
                                        </span>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-6 py-4 text-center text-gray-500">
                                    Aucun recrutement trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
