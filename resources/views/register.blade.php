<x-WelcomeLayout>
    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
        <!-- Formulario -->
        <div class="flex flex-col justify-center items-center px-8 py-12">
            <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl shadow-md p-8 w-full max-w-md border border-white border-opacity-30">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-20 mb-4">
                    <h2 class="text-2xl font-semibold mb-4">Make My Documentation</h2>
                    <h2 class="text-2xl font-semibold mb-4">Crear cuenta</h2>
                </div>
                {{-- Here we have to put errors with not done inputs --}}
                <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium mb-1">Nombre</label>
                        <input type="text" id="name" name="name" placeholder="Nombre" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" id="email" name="email" placeholder="Correo" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium mb-1">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="Contraseña" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex items-center text-sm">
                        <input type="checkbox" id="terms" class="mr-2">
                        <label for="terms">I agree to the <a href="#" class="text-blue-600 underline">terms & policy</a></label>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Registrar</button>
                </form>
            </div>
        </div>

        <!-- Imagen derecha -->
        <div class="hidden md:block p-4">
            <img src="{{ asset('images/panel.png') }}" alt="Code side" class="object-cover w-full h-full rounded-xl">
        </div>
    </div>
</x-WelcomeLayout>