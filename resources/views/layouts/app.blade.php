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

<body>
    <div class="flex">
        <aside class="fixed w-52 h-screen bg-[#0A1C3E]">
            <div class="flex flex-col h-full">
                <div class="p-4">
                    <img src="/logo.png" alt="Jet Logo" class="h-16 mx-auto">
                </div>
                <x-navbar />
            </div>
        </aside>
        <main class="ml-52 px-3 py-8 w-full bg-gray-200 min-h-screen">
            @yield('content')
        </main>
    </div>
    <script></script>
</body>

</html>
