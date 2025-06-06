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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
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
    <script>
        // Set custom iziToast defaults to match project theme
        iziToast.settings({
            timeout: 5000,
            resetOnHover: true,
            transitionIn: 'fadeInRight',
            transitionOut: 'fadeOutRight',
            transitionInMobile: 'fadeInRight',
            transitionOutMobile: 'fadeOutRight',
            progressBar: true,
            position: 'topRight',
        });

        // Check for flash messages and display with iziToast
        @if (session('success'))
            iziToast.success({
                title: 'Success',
                message: "{{ session('success') }}",
                backgroundColor: '#ffffff',
                titleColor: '#069401',
                messageColor: '#069401',
                iconColor: '#069401',
                progressBarColor: '#069401',
                cssClass: 'toast-ease-out'
            });
        @endif

        @if (session('message'))
            iziToast.success({
                title: 'Success',
                message: "{{ session('message') }}",
                backgroundColor: '#ffffff',
                titleColor: '#069401',
                messageColor: '#069401',
                iconColor: '#069401',
                progressBarColor: '#069401',
                cssClass: 'toast-ease-out'
            });
        @endif

        @if (session('error'))
            iziToast.error({
                title: 'Error',
                message: "{{ session('error') }}",
                backgroundColor: '#ffffff',
                titleColor: '#c40000',
                messageColor: '#c40000',
                iconColor: '#c40000',
                progressBarColor: '#c40000',
                cssClass: 'toast-ease-out'
            });
        @endif

        @if (session('info'))
            iziToast.info({
                title: 'Info',
                message: "{{ session('info') }}",
                backgroundColor: '#ffffff',
                titleColor: '#f99d25',
                messageColor: '#000000',
                iconColor: '#f99d25',
                progressBarColor: '#f99d25',
                cssClass: 'toast-ease-out'
            });
        @endif

        @if (session('warning'))
            iziToast.warning({
                title: 'Warning',
                message: "{{ session('warning') }}",
                backgroundColor: '#ffffff',
                titleColor: '#f99d25',
                messageColor: '#000000',
                iconColor: '#f99d25',
                progressBarColor: '#f99d25',
                cssClass: 'toast-ease-out'
            });
        @endif

        // Add custom style for ease-out transition
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                .toast-ease-out, .toast-ease-out * {
                    transition-timing-function: ease-out !important;
                    border-radius: 4px !important;
                    box-shadow: 0 3px 10px rgba(0,0,0,0.16) !important;
                }
            </style>
        `);
    </script>
</body>

</html>
