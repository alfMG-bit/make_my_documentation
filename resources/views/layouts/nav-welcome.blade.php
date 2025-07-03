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
        <a href="{{ route('register') }}" class="bg-blue-100 text-blue-800 px-12 py-1.5 rounded-full shadow hover:bg-blue-300 hover:scale-105 transition transform duration-200">Registrarme</a>
        <a href="{{ route('login') }}" class="bg-blue-100 text-blue-800 px-12 py-1.5 rounded-full shadow hover:bg-blue-300 hover:scale-105 transition transform duration-200">Iniciar Sesión</a>
    </div>
</header>