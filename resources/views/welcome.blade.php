<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make My Documentation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <header class="flex flex-col md:flex-row items-center justify-between px-8 py-2 bg-white bg-opacity-10 backdrop-blur-md shadow-md border border-white border-opacity-30">
        <div class="flex items-center gap-6 w-full md:w-auto">
            <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-14">
            <nav class="hidden md:flex gap-3 flex-nowrap text-sm font-medium items-center">
                <a href="#" class="bg-blue-100 text-blue-800 px-10 py-1.5 rounded-full shadow hover:bg-blue-300 hover:scale-105 transition transform duration-200">FAQ</a>
                <a href="#" class="bg-blue-100 text-blue-800 px-10 py-1.5 rounded-full shadow hover:bg-blue-300 hover:scale-105 transition transform duration-200">Política y Privacidad</a>
                <a href="#" class="bg-blue-100 text-blue-800 px-10 py-1.5 rounded-full shadow hover:bg-blue-300 hover:scale-105 transition transform duration-200">Sobre nosotros</a>
            </nav>
        </div>
        <div class="w-full flex justify-center md:justify-end mt-4 md:mt-0">
            <a href="/register" class="bg-blue-100 text-blue-800 px-12 py-1.5 rounded-full shadow hover:bg-blue-300 hover:scale-105 transition transform duration-200">Registrarme</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-white">
        <img src="{{ asset('images/cover.png') }}" alt="Hero Image" class="w-full h-auto rounded">

        <div class="flex flex-col justify-center">
            <h1 class="text-5xl font-bold">MMD <span class="text-sm font-normal ml-2">make my documentation</span></h1>
            <p class="mt-4 text-sm">
                ¿Eres desarrollador y debes documentar?, ¿Aún no tienes las bases y necesitas ayuda para ello? Pues... hemos llegado a ser tu pilar de la documentación.
            </p>
            <p class="mt-2 text-sm">
                Somos una herramienta impulsada por Inteligencia Artificial que te ayuda a complementar y/o darte una guía para tu documentación de desarrollo. También podrás tener la opción de crear tus diagramas de todo sin necesidad de otros softwares donde solo puedas crear un solo tipo en específico.
            </p>
            <p class="mt-2 text-sm">Inicia ahora e impulsa tu potencial de la documentación.</p>
            <a href="login" class="mt-4 w-fit bg-blue-100 text-blue-800 px-14 py-1.5 rounded-full shadow hover:bg-blue-300 hover:scale-105 transition transform duration-200">Iniciar ahora</a>
            <div class="mt-6 text-sm font-semibold flex gap-4">
                <span>Inteligencia Artificial</span>
                <span>Creación de diagramas</span>
                <span>Herramientas Multiusos</span>
            </div>
        </div>
    </section>

    <!-- Funciones Section -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-50">
        <div>
            <h2 class="text-4xl font-bold">FUNCIONES</h2>
            <h3 class="text-lg font-light">Documenta <span class="font-medium italic text-gray-600">profesionalmente</span></h3>
            <ul class="list-disc pl-5 mt-4 space-y-2 text-sm">
                <li><strong>Inteligencia Artificial:</strong> contamos con IA la cual te permite desarrollar, corregir y/o guiar tu documentación.</li>
                <li><strong>Diagramas:</strong> función para implementar diversos tipos de diagramas (casos de uso, flujo, entidad relación, etc.).</li>
                <li><strong>Exportación e importación:</strong> podrás importar tus proyectos en desarrollo para complementarlos o exportarlos en distintos formatos.</li>
            </ul>
        </div>
        <img src="{{ asset('images/ia.jpg') }}" alt="Funciones" class="w-full h-auto rounded">
    </section>

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
