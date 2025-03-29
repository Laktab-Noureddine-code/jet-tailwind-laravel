@extends('layouts.app')
@section('title' ,'Accounts')
@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Gestion des Comptes</h2>
        @if (session('success'))
            <div class="mb-4 p-2 bg-green-500 text-white rounded">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('accounts.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="name" placeholder="Nom" required class="p-2 border rounded">
                @error('name')
                    <p class="error">{{$message}}</p>
                @enderror
                <input type="email" name="email" placeholder="Email" required class="p-2 border rounded">
                @error('email')
                    <p class="error">{{$message}}</p>
                @enderror
                <input type="password" name="password" placeholder="Mot de passe" required class="p-2 border rounded">
                @error('password')
                    <p class="error">{{$message}}</p>
                @enderror
                <select name="role" required class="p-2 border rounded">
                    <option value="user">Utilisateur</option>
                    <option value="admin">Admin</option>
                </select>
                @error('role')
                    <p class="error">{{$message}}</p>
                @enderror
                @error('error')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded cursor-pointer">Ajouter</button>
        </form>

        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nom</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Rôle</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border p-2">{{ $user->name }}</td>
                        <td class="border p-2">{{ $user->email }}</td>
                        <td class="border p-2">{{ $user->role }}</td>
                        <td class="border p-2 flex">
                            <a href="{{route('accounts.edit' ,$user)}}" class="px-2 py-1 bg-gray-500 text-white rounded"><i class="fa-solid fa-user-pen"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
