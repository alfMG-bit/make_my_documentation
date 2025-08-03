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
            "model": "deepseek/deepseek-r1-0528-qwen3-8b:free",
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
          bubble.className = 'w-[100%] py-7 bg-gray-400';
          bubble.innerHTML = marked.parse(data.choices[0].message.content);
          chatArea.appendChild(bubble);
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