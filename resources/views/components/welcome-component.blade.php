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