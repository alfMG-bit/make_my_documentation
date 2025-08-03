<style>

  .chat-bot h1{
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 20px;
    margin-left: 20px
  }

  .chat-bot h2 {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 20px;
    margin: 0 25px;
  }

  .chat-bot h3 {
    font-size: 1.15rem;
    font-weight: 600;
    margin-bottom: 20px;
    margin: 0 25px;
  }

  .chat-bot strong {
    color: #852929;
  }
</style>

<!-- Chat Area -->
    <main class="flex-1 p-4 overflow-y-auto">
      <div id="chatArea" class="bg-white p-6 rounded shadow-md space-y-4">
        <p class="text-center text-gray-500">Aquí aparecerá el contenido del chat según lo que escriba el usuario.</p>
      </div>
    </main>

    <!-- Chat Input -->
    <div class="p-4">
      <div class="flex items-center bg-white rounded-full px-4 py-2 shadow gap-2">
        <!-- Botón para adjuntar archivos -->
        <div class="relative">
          <input type="file" id="fileInput" class="hidden" />
          <button id="attachFile" class="text-gray-500 hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656l-8.486 8.486a6 6 0 108.486 8.486L20 13" />
            </svg>
          </button>
        </div>

        <!-- Textarea -->
        <textarea id="messageInput" placeholder="Escribe un mensaje" class="flex-1 bg-transparent outline-none resize-none h-10 max-h-32" rows="1"></textarea>

        <!-- Botón enviar -->
        <button id="sendMessage" class="ml-2 text-blue-600 font-semibold cursor-pointer">Enviar</button>
      </div>
    </div>
  </div>

  <!-- Overlay -->
  <div id="drawerOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>

  <!-- Drawer izquierdo -->
  <div id="drawerMenu" class="fixed top-0 left-0 w-72 h-full bg-white/80 backdrop-blur-md shadow-lg z-50 transform -translate-x-full transition-transform duration-300 ease-in-out p-4 flex flex-col justify-between">
    <div class="space-y-4">
      <!-- Usuario -->
      <div class="flex items-center gap-4">
        <img src="{{ asset('images/user.png') }}" alt="Usuario" class="w-12 h-12 rounded-full">
        <div>
          <h3 class="font-semibold">Usuario Name</h3>
          <p class="text-sm text-gray-500">usuario@gmail.com</p>
        </div>
      </div>

      <!-- Buscador -->
      <div>
        <input type="text" placeholder="Search..." class="w-full px-3 py-2 rounded bg-gray-100 focus:outline-none">
      </div>

      <!-- Botón nuevo chat -->
      <button id="newChatBtn" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow transition mb-4">
        + Nuevo chat
      </button>

      <!-- Lista de chats -->
      <nav id="chatList" class="space-y-2">
        <!-- Chats dinámicos -->
      </nav>
    </div>

    <!-- Logout -->
    <form action="{{ route('logout.destroy') }}" class="relative mt-auto" method="POST">
      @csrf
      <input type="submit" name="submit" value="logout"
         class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg transition flex items-center gap-2"/>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-8V7a2 2 0 10-4 0v1" />
      </svg>
    </form>

    <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <script src=" https://cdn.jsdelivr.net/npm/mermaid@11.9.0/dist/mermaid.min.js "></script>
  <script>
  mermaid.initialize({ startOnLoad: false }); // No auto-render
</script>
  <script>
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

    // Variable saves deepseek api key
    const api_key = "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";

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
        bubble.className = 'bg-blue-600 text-white px-4 py-2 rounded w-fit max-w-xs hover:scale-105 transform transition';
        bubble.textContent = text;
        chatArea.appendChild(bubble);
        messageInput.value = '';
        messageInput.style.height = '2.5rem';

        fetch("https://openrouter.ai/api/v1/chat/completions", {
          method: "POST",
          headers: {
            "Authorization": "Bearer " + api_key,
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            "model": "deepseek/deepseek-r1-0528:free",
            "messages": [
              {
                "role": "user",
                "content": text
              }
            ]
          })
        }).then(response => response.json()).then(data => {
          console.log(data);
          const bubble = document.createElement('div');
          bubble.className = 'chat-bot w-[100%] py-7 bg-gray-400';
          bubble.innerHTML = marked.parse(data.choices[0].message.content);
          chatArea.appendChild(bubble);

          // Busca los bloques Mermaid en el nuevo contenido
          const mermaidBlocks = bubble.querySelectorAll('pre > code.language-mermaid');
          mermaidBlocks.forEach((block, index) => {
            const parent = block.parentElement;
            const graphDefinition = block.textContent;

            // Crea un contenedor para Mermaid
            const mermaidDiv = document.createElement('div');
            mermaidDiv.className = 'mermaid';
            mermaidDiv.textContent = graphDefinition;

            parent.replaceWith(mermaidDiv);

            try {
              mermaid.init(undefined, mermaidDiv);
            } catch (err) {
              console.error('Error renderizando Mermaid:', err);
            }
          });
        })
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
  </div>