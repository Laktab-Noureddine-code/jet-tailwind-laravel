<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jet Login</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    <div class="relative min-h-screen flex">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="/bg.jpg" class="w-full h-full object-cover filter brightness-50" alt="Background">
        </div>

        <!-- Content Container -->
        <div class="relative w-full flex items-center justify-center p-4">
            <div class="bg-white backdrop-blur-sm w-full max-w-md rounded-2xl shadow-2xl p-8 space-y-8">
                <!-- Logo -->
                <div class="flex justify-center">
                    <img src="/logo.png" class="h-24 drop-shadow-lg" alt="Logo">
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-center text-gray-900">
                    Bienvenue
                </h1>

                <!-- Login Form -->
                <form class="space-y-6" action="{{ route('login') }}" method="post">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-gray-700">
                            Adresse email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" id="email"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="nom@entreprise.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-medium text-gray-700">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Error Message -->
                    @error('failed')
                        <div class="bg-red-50 text-red-500 p-3 rounded-lg text-sm">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full flex justify-center items-center cursor-pointer py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se connecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
