<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kost Arcadia</title>

    <head>

        <script src="https://cdn.tailwindcss.com"></script>
    
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#765630',
                            background: '#F6F4F1',
                            border: '#D8CEC2',
                            gold: '#D9B56D',
                            secondary: '#745942',
                            'text-primary': '#111111',
                            'text-secondary': '#5E5A56',
                        },
    
                        fontFamily: {
                            serif: ['Cormorant Garamond'],
                            sans: ['Inter'],
                        },
                    }
                }
            }
        </script>
    
        <link
            href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap"
            rel="stylesheet"
        >

    {{-- Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

    {{-- Icons --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
        rel="stylesheet"
    >
</head>

<body class="bg-background text-text-primary antialiased">

    <x-navigation.navbar />

    <main>
        {{ $slot }}
    </main>

    <x-sections.footer />

</body>

</html>