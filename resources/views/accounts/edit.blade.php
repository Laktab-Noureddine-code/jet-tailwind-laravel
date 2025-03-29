@extends('layouts.app')
@section('title' ,'Accounts')
@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Modifier l'utilisateur</h2>

        @if (session('success'))
            <div class="mb-4 p-2 bg-green-500 text-white rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-2 bg-red-500 text-white rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('accounts.update', $account->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-bold mb-1">Nom</label>
                <input type="text" name="name" value="{{ old('name',$account->name) }}" 
                    class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $account->email) }}"
                    class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">Nouveau Mot de Passe</label>
                <input type="password" name="password" placeholder="Laissez vide pour ne pas changer"
                class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block font-bold mb-1">Rôle</label>
                <select name="role" required class="w-full p-2 border rounded">
                    <option {{ $account->role === "user" ? 'selected' : '' }} value="user">Utilisateur</option>
                    <option {{ $account->role === "admin" ? 'selected' : '' }} value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Mettre à jour</button>
            <a href="{{ route('accounts.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">Annuler</a>
        </form>
    </div>
@endsection
