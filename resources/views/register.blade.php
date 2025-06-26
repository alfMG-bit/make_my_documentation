<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Crear cuenta</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
        <!-- Imagen -->
        <div class="md:w-1/2 bg-blue-500 flex items-center justify-center p-8">
            <img src="{{ asset('img/register.png') }}" alt="Registro" class="w-3/4">
        </div>

        <!-- Formulario -->
        <div class="md:w-1/2 p-8">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Crear cuenta</h2>
            <form method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nombre</label>
                    <input type="text" name="name" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Contraseña</label>
                    <input type="password" name="password" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="terms" class="mr-2">
                    <label for="terms" class="text-sm text-gray-600">Acepto los términos y condiciones</label>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html>
