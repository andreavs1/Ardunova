<?php require_once __DIR__ . '/base.php'; ?>
<button class="chatbot-toggle" id="chatbotToggle" type="button" aria-label="Abrir asistente ARDUNOVA" aria-expanded="false">
  <span aria-hidden="true">💬</span>
</button>

<section class="chatbot-window" id="chatbotWindow" aria-label="Asistente ARDUNOVA">
  <div class="chatbot-header d-flex align-items-center justify-content-between">
    <div>
      <h2>Ardubot</h2>
      <p>Preguntame sobre Arduino y tus proyectos.</p>
    </div>
    <button class="chatbot-close" id="chatbotClose" type="button" aria-label="Cerrar chat">&times;</button>
  </div>

  <div class="chatbot-messages" id="chatbotMessages">
    <div class="chat-message bot">¡Hola! Soy el asistente de ARDUNOVA. ¿Qué querés aprender sobre Arduino?</div>
  </div>

  <form class="chatbot-form" id="chatbotForm">
    <input class="chatbot-input" id="chatbotInput" type="text" maxlength="1000" placeholder="Escribí tu pregunta..." autocomplete="off" required>
    <button class="chatbot-send" type="submit" aria-label="Enviar mensaje">➤</button>
  </form>
</section>

<script>
(function () {
  const toggle = document.getElementById('chatbotToggle');
  const close = document.getElementById('chatbotClose');
  const windowChat = document.getElementById('chatbotWindow');
  const form = document.getElementById('chatbotForm');
  const input = document.getElementById('chatbotInput');
  const messages = document.getElementById('chatbotMessages');

  function openChat() {
    windowChat.classList.add('show');
    toggle.setAttribute('aria-expanded', 'true');
    input.focus();
  }

  function closeChat() {
    windowChat.classList.remove('show');
    toggle.setAttribute('aria-expanded', 'false');
  }

  function addMessage(text, type) {
    const message = document.createElement('div');
    message.className = 'chat-message ' + type;
    message.textContent = text;
    messages.appendChild(message);
    messages.scrollTop = messages.scrollHeight;
    return message;
  }

  toggle.addEventListener('click', function () {
    windowChat.classList.contains('show') ? closeChat() : openChat();
  });

  close.addEventListener('click', closeChat);

  form.addEventListener('submit', async function (event) {
    event.preventDefault();

    const message = input.value.trim();
    if (!message) return;

    addMessage(message, 'user');
    input.value = '';
    input.disabled = true;

    const loading = addMessage('Estoy pensando...', 'bot');

    try {
      const response = await fetch('<?= $base ?>chatbot.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: message })
      });

      const data = await response.json();
      loading.remove();

      if (!response.ok || !data.reply) {
        addMessage(data.error || 'No pude responder en este momento.', 'bot');
        return;
      }

      addMessage(data.reply, 'bot');
    } catch (error) {
      loading.remove();
      addMessage('No pude conectarme con el asistente. Revisá la configuración del chatbot.', 'bot');
    } finally {
      input.disabled = false;
      input.focus();
    }
  });
})();
</script>
