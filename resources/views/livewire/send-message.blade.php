<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
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
        <textarea id="messageInput" placeholder="Escribe un mensaje" class="flex-1 bg-transparent outline-none resize-none h-10 max-h-32" rows="1" wire:model.live="message"></textarea>

        <!-- Botón enviar -->
        <button id="sendMessage" class="ml-2 text-blue-600 font-semibold cursor-pointer" wire:click="sendMessage">Enviar</button>
      </div>
    </div>

    <h1>{{ $message }}</h1>
    <script>console.log("Hola")</script>
    <script>
        document.addEventListener('livewire:init', () => {
          console.log("Livewire funcionando")
          Livewire.on('mm', (event) => {
            alert("HOLAA");
          });
        });
    </script>
</div>
