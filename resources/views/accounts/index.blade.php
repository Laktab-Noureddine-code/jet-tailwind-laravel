@extends('layouts.app')

@section('title', 'Gestion des Comptes Utilisateurs')

@section('content')
    <div class="container mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Comptes</h1>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-10">
            <div class="bg-[#0A1C3E] px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Ajouter un utilisateur</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('accounts.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                            <input type="text" name="name" placeholder="Nom" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" placeholder="Email" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                            <input type="password" name="password" placeholder="Mot de passe" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                            <select name="role" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] appearance-none bg-white">
                                <option value="user">Utilisateur</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-3 cursor-pointer border border-transparent rounded-md text-sm font-medium text-white bg-[#0A1C3E] hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E] transition-all duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-user-plus"></i>
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-[#0A1C3E] px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Liste des Utilisateurs</h2>
            </div>
            <div class="overflow-x-auto p-2">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="text-xs uppercase bg-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium text-gray-700">Nom</th>
                            <th scope="col" class="px-6 py-3 font-medium text-gray-700">Email</th>
                            <th scope="col" class="px-6 py-3 font-medium text-gray-700">Rôle</th>
                            <th scope="col" class="px-6 py-3 text-center font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 h-[50px] font-medium">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold 
                                        {{ $user->role === 'admin' ? 'bg-[#0A1C3E] text-white' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center space-x-4">
                                        <a href="{{ route('accounts.edit', $user->id) }}"
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-150"
                                            title="Modifier">
                                            <i class="fa-solid fa-user-pen"></i>
                                        </a>
                                        @if (!($user->role === 'admin' && \App\Models\User::where('role', 'admin')->count() === 2))
                                            <button onclick="deleteUser({{ $user->id }})"
                                                class="text-red-600 hover:text-red-900 transition-colors duration-150"
                                                title="Supprimer">
                                                <i class="fa-solid fa-user-minus"></i>
                                            </button>
                                            <form id="delete-form-{{ $user->id }}"
                                                action="{{ route('accounts.destroy', $user->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function deleteUser(userId) {
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Confirmation',
                message: 'Êtes-vous sûr de vouloir supprimer cet utilisateur?',
                position: 'center',
                buttons: [
                    ['<button><b>Oui</b></button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');
                        document.getElementById('delete-form-' + userId).submit();
                    }, true],
                    ['<button>Non</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');
                    }],
                ],
                onClosing: function(instance, toast, closedBy) {
                    console.info('Closing | closedBy: ' + closedBy);
                },
                onClosed: function(instance, toast, closedBy) {
                    console.info('Closed | closedBy: ' + closedBy);
                }
            });
        }
    </script>
@endsection
