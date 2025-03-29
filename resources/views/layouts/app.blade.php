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
        <section class="fixed max-w-[16%] min-w-[16%] h-screen top-0 bg-gray-800 text-white flex flex-col ">
            <img src="/logo.png" class="h-[100px] mx-auto py-4">
            <div id="navbar" class="flex-1">
                <x-navbar />
            </div>
        </section>
        <main class="ml-[16%] px-2 py-5 w-full bg-[#f6f7f9] min-h-screen">
            @yield('content')
        </main>
    </div>
    <script>
        
    </script>
</body>

</html>
