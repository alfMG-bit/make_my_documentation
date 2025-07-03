<x-WelcomeLayout>
    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
        <!-- Formulario -->
        <div class="flex flex-col justify-center items-center px-8 py-12">
            <div class="bg-white bg-opacity-70 backdrop-blur-md rounded-xl shadow-md p-8 w-full max-w-md">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-20 mb-4">
                    <h2 class="text-2xl font-semibold mb-2">¡Bienvenido!</h2>
                    <p class="text-sm mb-8 text-center">Ingresa tus datos para iniciar sesión.</p>
                </div>

                <form action="#" method="POST" class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" id="email" name="email" placeholder="Ingresa tu Email" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <label for="password" class="block text-sm font-medium mb-1">Contraseña</label>
                            <a href="#" class="text-sm text-blue-600 hover:underline">Olvide mi contraseña</a>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Login</button>
                </form>

                <p class="mt-8 text-sm text-center">¿No tienes cuenta? <a href="{{ url('/register') }}" class="text-blue-600 hover:underline">Regístrate</a></p>
            </div>
        </div>

        <div class="hidden md:block p-4">
            <img src="{{ asset('images/panel.png') }}" alt="Code side" class="object-cover w-full h-full rounded-xl">
        </div>
    </div>
</x-WelcomeLayout>