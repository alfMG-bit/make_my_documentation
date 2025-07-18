<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - MMD</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
  @vite(["resources/css/app.css","resources/js/app.js"])
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
      <button id="openDrawer" class="mr-4 cursor-pointer">
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

    <!-- HERE MUST BE COMPONENTS -->
    {{ $slot }}

  <!-- Scripts -->
  <script>
    // API KEY: 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
    fetch("https://openrouter.ai/api/v1/chat/completions", {
        method: "POST",
        headers: {
            "Authorization": "Bearer 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",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "model": "deepseek/deepseek-r1-0528-qwen3-8b:free",
            "messages": [
            {
                "role": "user",
                "content": "What is the meaning of life?"
            }
            ]
        })
    });

    const drawer = document.getElementById('drawerMenu');
    const overlay = document.getElementById('drawerOverlay');
    const openDrawer = document.getElementById('openDrawer');
    const messageInput = document.getElementById('messageInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatArea = document.getElementById('chatArea');
    const attachFile = document.getElementById('attachFile');
    const fileInput = document.getElementById('fileInput');
    const newChatBtn = document.getElementById('newChatBtn');
    const chatList = document.getElementById('chatList');

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
      if (event.key === 'Escape') closeDrawer();
    });

    function enviarMensaje() {
      const text = messageInput.value.trim();
      if (text !== '') {
        const bubble = document.createElement('div');
        bubble.className = 'bg-blue-600 text-white px-4 py-2 rounded-full w-fit max-w-xs hover:scale-105 transform transition';
        bubble.textContent = text;
        chatArea.appendChild(bubble);
        messageInput.value = '';
        messageInput.style.height = '2.5rem';
      }
    }

    sendMessage.addEventListener('click', enviarMensaje);

    messageInput.addEventListener('keydown', (event) => {
      if (event.key === 'Enter') {
        if (event.shiftKey) return;
        event.preventDefault();
        enviarMensaje();
      }
    });

    messageInput.addEventListener('input', () => {
      messageInput.style.height = '2.5rem';
      messageInput.style.height = messageInput.scrollHeight + 'px';
    });

    attachFile.addEventListener('click', () => {
      fileInput.click();
    });

    fileInput.addEventListener('change', () => {
      const file = fileInput.files[0];
      if (file) {
        const fileBubble = document.createElement('div');
        fileBubble.className = 'bg-gray-200 text-sm px-4 py-2 rounded w-fit max-w-xs';
        fileBubble.textContent = `Archivo adjuntado: ${file.name}`;
        chatArea.appendChild(fileBubble);
      }
    });

    newChatBtn.addEventListener('click', () => {
      const newChat = document.createElement('button');
      newChat.className = 'w-full text-left px-4 py-2 rounded hover:bg-blue-100 transition text-sm';
      newChat.textContent = 'Nuevo Chat ' + (chatList.children.length + 1);
      chatList.appendChild(newChat);
    });
  </script>
</body>
</html>
