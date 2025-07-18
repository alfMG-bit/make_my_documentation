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
        <button id="sendMessage" class="ml-2 text-blue-600 font-semibold">Enviar</button>
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
  </div>