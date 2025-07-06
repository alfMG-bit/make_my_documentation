<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - MMD</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100">
  <div class="flex flex-col h-screen overflow-hidden">
    
    <!-- Topbar -->
    <header class="flex items-center justify-between p-4 shadow-md bg-white dark:bg-gray-800">
      <nav class="hidden md:flex gap-8 font-medium mx-auto">
        <a href="#" class="hover:underline">Home</a>
        <a href="#" class="hover:underline">About</a>
        <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-8">
        <a href="#" class="hover:underline">Documentation</a>
        <a href="#" class="hover:underline">FAQ</a>
      </nav>
      <!-- Botón para abrir el drawer -->
      <button id="openDrawer" class="ml-4 md:ml-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </header>

    <!-- Chat Area -->
    <main class="flex-1 p-4 overflow-y-auto">
      <div id="chatArea" class="bg-white dark:bg-gray-800 p-6 rounded shadow-md space-y-4">
        <p class="text-center text-gray-500 dark:text-gray-400">Aquí aparecerá el contenido del chat según lo que escriba el usuario.</p>
      </div>
    </main>

    <!-- Chat Input -->
    <div class="p-4">
      <div class="flex items-center bg-white dark:bg-gray-800 rounded-full px-4 py-2 shadow">
        <input type="text" id="messageInput" placeholder="Type message" class="flex-1 bg-transparent outline-none">
        <button id="sendMessage" class="ml-4 text-blue-600">Enviar</button>
      </div>
    </div>
  </div>

  <!-- Overlay -->
  <div id="drawerOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>

  <!-- Drawer derecho -->
  <div id="drawerMenu" class="fixed top-0 right-0 w-72 h-full bg-white dark:bg-gray-800 shadow-lg z-50 transform translate-x-full transition-transform duration-300 ease-in-out p-4 space-y-4">
    <!-- Usuario -->
    <div class="flex items-center gap-4">
      <img src="{{ asset('images/user.png') }}" alt="Usuario" class="w-12 h-12 rounded-full">
      <div>
        <h3 class="font-semibold">Usuario Name</h3>
        <p class="text-sm text-gray-500 dark:text-gray-300">usuario@gmail.com</p>
      </div>
    </div>

    <!-- Búsqueda -->
    <div>
      <input type="text" placeholder="Search..." class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 focus:outline-none">
    </div>

    <!-- Lista de chats -->
    <nav id="chatList" class="space-y-2">
      <!-- Chats dinámicos -->
    </nav>

    <!-- Opciones -->
    <div class="space-y-2 pt-4">
      <a href="#" class="block px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Logout</a>
      <button id="toggleDark" class="flex items-center gap-2 px-3 py-2 rounded bg-gray-200 dark:bg-gray-700 w-full justify-center">
        <span id="modeLabel">Light mode</span>
        <svg id="themeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm0 14a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm8-6a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM4 10a1 1 0 01-1 1H2a1 1 0 110-2h1a1 1 0 011 1zm11.657-5.657a1 1 0 010 1.414L15.414 7.1a1 1 0 01-1.414-1.414l1.243-1.243a1 1 0 011.414 0zM6.343 13.657a1 1 0 010 1.414L5.1 16.314a1 1 0 11-1.414-1.414l1.243-1.243a1 1 0 011.414 0zM16.314 14.9a1 1 0 00-1.414 1.414l1.243 1.243a1 1 0 001.414-1.414l-1.243-1.243zM7.1 5.1a1 1 0 00-1.414 1.414L6.93 7.757a1 1 0 001.414-1.414L7.1 5.1z" />
        </svg>
      </button>
    </div>
  </div>

  <script>
    const drawer = document.getElementById('drawerMenu');
    const overlay = document.getElementById('drawerOverlay');
    const openDrawer = document.getElementById('openDrawer');
    const toggleDark = document.getElementById('toggleDark');
    const modeLabel = document.getElementById('modeLabel');
    const chatArea = document.getElementById('chatArea');
    const messageInput = document.getElementById('messageInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatList = document.getElementById('chatList');

    openDrawer.addEventListener('click', () => {
      drawer.classList.remove('translate-x-full');
      overlay.classList.remove('hidden');
      overlay.classList.add('opacity-100');
    });

    function closeDrawer() {
      drawer.classList.add('translate-x-full');
      overlay.classList.add('hidden');
      overlay.classList.remove('opacity-100');
    }

    overlay.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeDrawer();
      }
    });

    toggleDark.addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');
      const isDark = document.documentElement.classList.contains('dark');
      modeLabel.textContent = isDark ? 'Dark mode' : 'Light mode';
    });

    sendMessage.addEventListener('click', () => {
      const text = messageInput.value.trim();
      if (text !== '') {
        const bubble = document.createElement('div');
        bubble.className = 'bg-blue-600 text-white px-4 py-2 rounded-full w-fit max-w-xs hover:scale-105 transform transition';
        bubble.textContent = text;
        chatArea.appendChild(bubble);
        messageInput.value = '';
      }
    });
  </script>
</body>
</html>
