<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Installer</title>
    @livewireStyles
    @vite(['resources/css/app.css'])  
</head>
<body>
    <main>
        <header>
            <nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-gray-200">
                <div class="max-w-screen-xl flex flex-wrap items-center justify-center mx-auto p-4">
                    <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="{{ asset('assets/static/logo.svg') }}" class="h-8" alt="Flowbite Logo">
                    </a>
                </div>
            </nav>
        </header>        
        <div class="mt-20">
            <div class="p-5 flex justify-center">
                {{ $slot }}
            </div>
        </div>
    </main>
    @livewireScripts
</body>
</html>
