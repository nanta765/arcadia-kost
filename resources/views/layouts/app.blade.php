<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->user()->id ?? '' }}">
    <title>{{ config('app.name', 'Arcadia') }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Earthy Luxury Theme -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        cream: {50:'#FFF7ED',100:'#FFEDD5',500:'#FDBA74'},
                        tan: {50:'#FEF7F2',100:'#FEE8D9',500:'#F59E0B'},
                        gold: {400:'#FBBF24',500:'#F59E0B'}
                    },
                    fontFamily: {
                        display: ['Poppins', 'sans-serif'],
                        body: ['Poppins', 'sans-serif']
                    },
                    backdropBlur: {xs: '2px'}
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @livewireStyles
    @filamentStyles
</head>
<body class="antialiased font-body bg-gradient-to-br from-cream-50 to-tan-50 dark:from-zinc-900 dark:to-zinc-800">
    {{ $slot }}
    
    {{-- Chat Widget for customers --}}
    <x-chat-widget />

    @livewireScripts
    @filamentScripts
</body>
</html>