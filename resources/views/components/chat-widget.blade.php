@auth
{{-- Only show chat widget for authenticated customers --}}
@if(auth()->user()->role === 'customer')

{{-- Chat Floating Button --}}
<div id="chat-widget-container">
    {{-- Floating Bubble Button --}}
    <button id="chat-toggle-btn" onclick="toggleChat()" aria-label="Chat Support">
        <span class="material-symbols-outlined" id="chat-icon-open" style="font-size:26px;">chat_bubble</span>
        <span class="material-symbols-outlined" id="chat-icon-close" style="font-size:22px;display:none;">close</span>
        <span id="chat-unread-badge" style="display:none;"></span>
    </button>

    {{-- Chat Window --}}
    <div id="chat-window" style="display:none;">
        {{-- Header --}}
        <div id="chat-header">
            <div style="display:flex;align-items:center;gap:10px;">
                <div id="chat-avatar">
                    <span class="material-symbols-outlined" style="font-size:20px;">person</span>
                </div>
                <div>
                    <div id="chat-header-title">Staff Arcadia</div>
                    <div id="chat-header-subtitle">Typically replies within a few minutes</div>
                </div>
            </div>
            <button onclick="toggleChat()" style="background:none;border:none;cursor:pointer;padding:4px;">
                <span class="material-symbols-outlined" style="font-size:18px;color:rgba(255,255,255,0.6);">close</span>
            </button>
        </div>

        {{-- Messages Area --}}
        <div id="chat-messages">
            <div id="chat-welcome-msg">
                <div style="width:42px;height:42px;border-radius:50%;background:#0A0A0A;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    <span class="material-symbols-outlined" style="font-size:22px;color:#fff;">chat_bubble</span>
                </div>
                <div style="font-weight:600;color:#0A0A0A;margin-bottom:4px;font-size:0.92rem;">Welcome!</div>
                <div style="font-size:0.78rem;color:#4B5563;line-height:1.5;">Send a message to reach Arcadia Kost staff. We're here to help.</div>
            </div>
        </div>

        {{-- Input Area --}}
        <div id="chat-input-area">
            <form id="chat-form" onsubmit="sendChatMessage(event)">
                <input type="text" id="chat-input" placeholder="Type a message..." autocomplete="off" maxlength="1000">
                <button type="submit" id="chat-send-btn" aria-label="Send">
                    <span class="material-symbols-outlined" style="font-size:20px;">send</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* === CHAT WIDGET STYLES === */
    #chat-widget-container {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        font-family: 'Inter', sans-serif;
    }

    /* Floating toggle button */
    #chat-toggle-btn {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #0A0A0A;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 28px rgba(0,0,0,0.25);
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        position: relative;
        color: #fff;
    }
    #chat-toggle-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 8px 36px rgba(0,0,0,0.35);
    }

    /* Unread badge */
    #chat-unread-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #ef4444;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2.5px solid #fff;
        animation: badgePulse 2s infinite;
    }
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    /* Chat window */
    #chat-window {
        position: absolute;
        bottom: 72px;
        right: 0;
        width: 370px;
        max-height: 520px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 12px 48px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: chatSlideUp 0.35s cubic-bezier(0.4,0,0.2,1);
    }
    @keyframes chatSlideUp {
        from { opacity: 0; transform: translateY(16px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Header */
    #chat-header {
        background: #0A0A0A;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    #chat-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }
    #chat-header-title {
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
    }
    #chat-header-subtitle {
        color: rgba(255,255,255,0.45);
        font-size: 0.7rem;
        margin-top: 1px;
    }

    /* Messages area */
    #chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 18px 16px;
        background: #F3F4F6;
        min-height: 280px;
        max-height: 340px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    #chat-messages::-webkit-scrollbar { width: 5px; }
    #chat-messages::-webkit-scrollbar-track { background: transparent; }
    #chat-messages::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 10px; }

    /* Welcome message */
    #chat-welcome-msg {
        text-align: center;
        padding: 18px 14px;
        background: #fff;
        border-radius: 14px;
        border: 1px solid #E5E7EB;
    }

    /* Message bubbles */
    .chat-bubble {
        max-width: 82%;
        padding: 10px 14px;
        border-radius: 16px;
        font-size: 0.84rem;
        line-height: 1.55;
        word-wrap: break-word;
        position: relative;
        animation: bubbleFade 0.25s ease;
    }
    @keyframes bubbleFade {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .chat-bubble.own {
        align-self: flex-end;
        background: #0A0A0A;
        color: #fff;
        border-bottom-right-radius: 4px;
    }
    .chat-bubble.other {
        align-self: flex-start;
        background: #fff;
        color: #333;
        border: 1px solid #E5E7EB;
        border-bottom-left-radius: 4px;
    }
    .chat-bubble .bubble-meta {
        font-size: 0.62rem;
        margin-top: 5px;
        opacity: 0.6;
    }
    .chat-bubble.own .bubble-meta { text-align: right; }
    .chat-bubble.other .bubble-meta { text-align: left; }
    .chat-bubble .bubble-sender {
        font-size: 0.68rem;
        font-weight: 600;
        margin-bottom: 3px;
        opacity: 0.75;
    }

    /* Input area */
    #chat-input-area {
        padding: 12px 14px;
        background: #fff;
        border-top: 1px solid #E5E7EB;
        flex-shrink: 0;
    }
    #chat-form {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    #chat-input {
        flex: 1;
        padding: 10px 14px;
        border: 1.5px solid #E5E7EB;
        border-radius: 100px;
        font-size: 0.84rem;
        font-family: inherit;
        outline: none;
        background: #F3F4F6;
        transition: border-color 0.2s;
        color: #0A0A0A;
    }
    #chat-input:focus {
        border-color: #0A0A0A;
        background: #fff;
    }
    #chat-input::placeholder {
        color: #9CA3AF;
    }
    #chat-send-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #0A0A0A;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s;
        color: #fff;
    }
    #chat-send-btn:hover {
        transform: scale(1.08);
    }

    /* Responsive */
    @media (max-width: 440px) {
        #chat-window {
            width: calc(100vw - 32px);
            right: -8px;
            bottom: 68px;
            max-height: 70vh;
        }
    }
</style>

<script>
    let chatId = null;
    let chatOpen = false;
    let chatPollInterval = null;
    let lastMessageId = 0;

    function toggleChat() {
        const win = document.getElementById('chat-window');
        const iconOpen = document.getElementById('chat-icon-open');
        const iconClose = document.getElementById('chat-icon-close');
        chatOpen = !chatOpen;

        if (chatOpen) {
            win.style.display = 'flex';
            iconOpen.style.display = 'none';
            iconClose.style.display = 'block';
            hideBadge();
            initChat();
        } else {
            win.style.display = 'none';
            iconOpen.style.display = 'block';
            iconClose.style.display = 'none';
            stopPolling();
        }
    }

    async function initChat() {
        try {
            const res = await fetch('/chat/active', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': getCSRF() }
            });
            const data = await res.json();
            chatId = data.chat_id;
            await loadMessages();
            startPolling();
        } catch (e) {
            console.error('Chat init error:', e);
        }
    }

    async function loadMessages() {
        if (!chatId) return;
        try {
            const res = await fetch(`/chat/${chatId}/messages`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': getCSRF() }
            });
            const data = await res.json();
            renderMessages(data.messages);

            if (data.staff_name) {
                document.getElementById('chat-header-title').textContent = data.staff_name;
                document.getElementById('chat-header-subtitle').textContent = 'Staff Arcadia Kost';
            }
        } catch (e) {
            console.error('Load messages error:', e);
        }
    }

    function renderMessages(messages) {
        const container = document.getElementById('chat-messages');
        const welcome = document.getElementById('chat-welcome-msg');

        if (messages.length === 0) {
            if (welcome) welcome.style.display = 'block';
            return;
        }

        if (welcome) welcome.style.display = 'none';

        // Clear existing bubbles
        container.querySelectorAll('.chat-bubble').forEach(el => el.remove());

        messages.forEach(msg => {
            const bubble = document.createElement('div');
            bubble.className = `chat-bubble ${msg.is_own ? 'own' : 'other'}`;
            bubble.dataset.id = msg.id;

            let html = '';
            if (!msg.is_own) {
                html += `<div class="bubble-sender">${escapeHtml(msg.sender_name)}</div>`;
            }
            html += `<div>${escapeHtml(msg.message)}</div>`;
            html += `<div class="bubble-meta">${msg.formatted_time}</div>`;
            bubble.innerHTML = html;
            container.appendChild(bubble);

            if (msg.id > lastMessageId) lastMessageId = msg.id;
        });

        scrollToBottom();
    }

    async function sendChatMessage(event) {
        event.preventDefault();
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message || !chatId) return;

        input.value = '';

        try {
            const res = await fetch(`/chat/${chatId}/message`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCSRF()
                },
                body: JSON.stringify({ message })
            });
            const data = await res.json();

            if (data.success) {
                await loadMessages();
            }
        } catch (e) {
            console.error('Send message error:', e);
        }
    }

    function startPolling() {
        stopPolling();
        chatPollInterval = setInterval(loadMessages, 3000);
    }
    function stopPolling() {
        if (chatPollInterval) clearInterval(chatPollInterval);
        chatPollInterval = null;
    }

    function scrollToBottom() {
        const container = document.getElementById('chat-messages');
        container.scrollTop = container.scrollHeight;
    }

    function hideBadge() {
        document.getElementById('chat-unread-badge').style.display = 'none';
    }

    function getCSRF() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endif
@endauth
