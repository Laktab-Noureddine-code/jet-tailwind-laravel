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

<body>
    <section class="bg-gray-50 flex min-h-screen">
        <div class="flex-[45%] relative">
            <img src="/bg.jpg" class="w-full object-cover h-screen filter brightness-95">
            <img src="/logo.png" class="absolute drop-shadow-white top-10 h-[140px] left-[50%] translate-x-[-50%]">
        </div>
        <div class="flex-[55%]">
            <div class="flex flex-col items-center justify-center mx-auto md:h-screen lg:py-0">
                <div class="w-full md:mt-0 xl:p-0">
                    <div class=" md:space-y-6 sm:p-8 w-full ">
                        <h1 class="text-[50px] font-bold text-center leading-tight tracking-tight mb-10 text-gray-900">
                            Se connecter 
                        </h1>
                        <form class="md:space-y-6 w-full px-20" action="{{ route('login') }}" method="post">
                            @csrf
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Your
                                    email</label>
                                <input type="email" name="email" id="email"
                                    class="bg-gray-50 border border-gray-600 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  "
                                    placeholder="name@company.com" value="{{ old('email') }}" required="">
                            </div>
                            <div>
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-600 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                                    required="">
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="remember" aria-describedby="remember" type="checkbox"
                                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 ">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="remember" class="text-gray-500">Se souvenir de moi</label>
                                    </div>
                                </div>
                            </div>
                            @error('failed')
                                <span class="error">{{ $message }}</span>
                            @enderror
                            <button type="submit"
                                class="w-full text-white bg-gray-800 cursor-pointer hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Se connecter
                            </button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
