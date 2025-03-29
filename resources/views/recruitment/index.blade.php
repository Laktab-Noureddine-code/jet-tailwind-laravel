<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
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


        <table class="table mt-3">
            @if (session('success'))
                <div class="message">{{ session('success') }}</div>
            @endif
            <thead>
                <tr class="tr">
                    <th class="pl-2">Nom</th>
                    <th class="pl-2">Email</th>
                    <th class="pl-2">Fonction</th>
                    <th class="pl-2">Type de Contrat</th>
                    <th class="pl-2">Téléphone</th>
                    <th class="pl-2">Modèle</th>
                    <th class="pl-2">Numéro de Série</th>
                    <th class="pl-2">Puk</th>
                    <th class="pl-2">Pin</th>
                    <th class="pl-2">statut</th>
                    <th class="pl-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recrutements as $recrutement)
                    <tr class="border-b border-gray-200 text-sm">
                        <td>{{ $recrutement->nom }}</td>
                        <td>{{ $recrutement->email }}</td>
                        <td>{{ $recrutement->fonction }}</td>
                        <td>{{ $recrutement->type_contrat }}</td>
                        <td>{{ $recrutement->telephone }}</td>
                        <td>{{ $recrutement->model }}</td>
                        <td>{{ $recrutement->num_serie }}</td>
                        <td>{{ $recrutement->puk }}</td>
                        <td>{{ $recrutement->pin }}</td>
                        <td>{{ $recrutement->status }}</td>
                        @if ($recrutement->status !== 'validé')
                            <td class="flex justify-center items-center gap-3">
                                <a href="{{ route('recrutements.edit', $recrutement) }}" class=""><i
                                        class="fa-solid fa-pen-to-square text-lg text-blue-900"></i></a>
                                <form action="{{ route('recrutements.destroy', $recrutement) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cursor-pointer"
                                        onclick="return confirm('Êtes-vous sûr ?')"><i
                                            class="fa-solid fa-trash text-red-500 text-lg"></i></button>
                                </form>
                            </td>
                        @else
                            <td class="flex justify-center items-center">
                                <span class="bg-green-500 px-2 py-1 rounded-lg text-white font-semibold">Validé</span>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-4">Aucun recrutement trouvé.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</body>

</html>
