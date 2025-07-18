<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make My Documentation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    @vite(["resources/css/app.css","resources/js/app.js"])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    @if (Route::currentRouteName() === "welcome")
        @include('layouts.nav-welcome')
    @endif
    <!-- Hero Section -->
    {{ $slot }}
    <!-- Footer -->
    <footer class="bg-white border-t p-8 text-sm text-center">
        <div class="flex flex-col md:flex-row md:justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/icon.png') }}" alt="Logo Footer" class="h-14">
                <span>Contáctenos: mmd@gmail.com</span>
            </div>
            <div class="mt-4 md:mt-0 text-left">
                <p class="font-semibold">Usuario:</p>
                <p>Agradecemos tu preferencia, dudas y comentarios para mejorar el sistema serán agradecidos.</p>
                <p class="italic">¡A documentar!</p>
            </div>
        </div>
        <p class="mt-4 text-gray-400">Copyright &copy; 2025 Make My Documentation. All rights reserved.</p>
    </footer>
</body>
</html>
