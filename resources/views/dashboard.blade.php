<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - MMD</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="flex flex-col h-screen overflow-hidden">

    <!-- Topbar -->
    <header class="flex items-center justify-between p-4 shadow-md bg-white">
      <!-- Botón para abrir el drawer (izquierda) -->
      <button id="openDrawer" class="mr-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <nav class="hidden md:flex gap-8 font-medium mx-auto">
        <a href="#" class="hover:underline">Home</a>
        <a href="#" class="hover:underline">About</a>
        <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-8">
        <a href="#" class="hover:underline">Documentation</a>
        <a href="#" class="hover:underline">FAQ</a>
      </nav>
    </header>

    <!-- Chat Area -->
    <main class="flex-1 p-4 overflow-y-auto">
      <div id="chatArea" class="bg-white p-6 rounded shadow-md space-y-4">
        <p class="text-center text-gray-500">Aquí aparecerá el contenido del chat según lo que escriba el usuario.</p>
      </div>
    </main>

    <!-- Chat Input -->
    <div class="p-4">
      <div class="flex items-center bg-white rounded-full px-4 py-2 shadow">
        <textarea id="messageInput" placeholder="Type message" class="flex-1 bg-transparent outline-none resize-none h-10 max-h-32" rows="1"></textarea>
        <button id="sendMessage" class="ml-4 text-blue-600">Enviar</button>
      </div>
    </div>
  </div>

  <!-- Overlay -->
  <div id="drawerOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>

  <!-- Drawer izquierdo con transparencia -->
  <div id="drawerMenu" class="fixed top-0 left-0 w-72 h-full bg-white/80 backdrop-blur-md shadow-lg z-50 transform -translate-x-full transition-transform duration-300 ease-in-out p-4 flex flex-col justify-between">
    
    <!-- Contenido superior del drawer -->
    <div class="space-y-4">
      <!-- Usuario -->
      <div class="flex items-center gap-4">
        <img src="{{ asset('images/user.png') }}" alt="Usuario" class="w-12 h-12 rounded-full">
        <div>
          <h3 class="font-semibold">Usuario Name</h3>
          <p class="text-sm text-gray-500">usuario@gmail.com</p>
        </div>
      </div>

      <!-- Búsqueda -->
      <div>
        <input type="text" placeholder="Search..." class="w-full px-3 py-2 rounded bg-gray-100 focus:outline-none">
      </div>

      <!-- Lista de chats -->
      <nav id="chatList" class="space-y-2">
        <!-- Chats dinámicos -->
      </nav>
    </div>

    <!-- Botón Logout estilo burbuja azul con ícono -->
    <div class="relative mt-auto">
      <a href="#"
         class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg transition flex items-center gap-2">
        <!-- Heroicon: Logout -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-8V7a2 2 0 10-4 0v1" />
        </svg>
        Logout
      </a>
    </div>
  </div>

  <script>
    const drawer = document.getElementById('drawerMenu');
    const overlay = document.getElementById('drawerOverlay');
    const openDrawer = document.getElementById('openDrawer');
    const messageInput = document.getElementById('messageInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatArea = document.getElementById('chatArea');

    openDrawer.addEventListener('click', () => {
      drawer.classList.remove('-translate-x-full');
      overlay.classList.remove('hidden');
      overlay.classList.add('opacity-100');
    });

    function closeDrawer() {
      drawer.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
      overlay.classList.remove('opacity-100');
    }

    overlay.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeDrawer();
      }
    });

    function enviarMensaje() {
      const text = messageInput.value.trim();
      if (text !== '') {
        const bubble = document.createElement('div');
        bubble.className = 'bg-blue-600 text-white px-4 py-2 rounded-full w-fit max-w-xs hover:scale-105 transform transition';
        bubble.textContent = text;
        chatArea.appendChild(bubble);
        messageInput.value = '';
        messageInput.style.height = '2.5rem'; // Reset altura textarea
      }
    }

    sendMessage.addEventListener('click', enviarMensaje);

    messageInput.addEventListener('keydown', (event) => {
      if (event.key === 'Enter') {
        if (event.shiftKey) {
          // Permitir salto de línea
          return;
        }
        event.preventDefault();
        enviarMensaje();
      }
    });

    // Ajuste dinámico de altura del textarea (opcional)
    messageInput.addEventListener('input', () => {
      messageInput.style.height = '2.5rem'; // reset para recalc
      messageInput.style.height = messageInput.scrollHeight + 'px';
    });
  </script>
</body>
</html>
