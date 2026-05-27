<x-filament-panels::page>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">

    <div class="arca-chat-wrapper">
        <div class="chat-sidebar">
            <div class="sidebar-header">
                <h2>Messages</h2>
            </div>
            <div class="sidebar-list" id="chat-list">
                <div class="empty-text">Loading conversations...</div>
            </div>
        </div>

        <div class="chat-main">
            <div class="chat-header" id="chat-header" style="visibility: hidden;">
                <div class="header-profile">
                    <div class="tenant-avatar active-avatar" id="active-avatar-text">U</div>
                    <div>
                        <h3 id="chat-partner-name">Tenant Name</h3>
                        <p class="status-online"><span class="dot"></span> Online</p>
                    </div>
                </div>
                <button id="clear-chat-btn" class="btn-delete-chat" title="Clear Chat">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>

            <div id="chat-messages" class="chat-body">
                <div class="chat-empty-board" id="empty-state-board">
                    <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="title">Open a Conversation</p>
                    <p class="subtitle">Select a name on the left to respond to tenant messages.</p>
                </div>
            </div>

            <div class="chat-footer" id="chat-footer" style="visibility: hidden;">
                <form id="chat-form" class="form-send" onsubmit="sendStaffMessage(event)">
                    <input type="text" id="chat-input" placeholder="Type a message..." autocomplete="off">
                    <button type="submit" id="chat-send-btn">
                        <span>Send</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .arca-chat-wrapper { display: flex; height: 72vh; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .dark .arca-chat-wrapper { background: #111827; border-color: #1f2937; }
        .chat-sidebar { width: 30%; min-width: 260px; border-right: 1px solid #e5e7eb; background: #f9fafb; display: flex; flex-direction: column; }
        .dark .chat-sidebar { border-color: #1f2937; background: #1f2937; }
        .sidebar-header { padding: 16px; background: #ffffff; border-bottom: 1px solid #e5e7eb; }
        .dark .sidebar-header { background: #111827; border-color: #1f2937; }
        .sidebar-header h2 { font-size: 16px; font-weight: 700; color: #111827; }
        .dark .sidebar-header h2 { color: #f9fafb; }
        .sidebar-list { flex: 1; overflow-y: auto; }
        .tenant-item { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; gap: 12px; }
        .dark .tenant-item { border-color: #1f2937; }
        .tenant-item:hover { background: #f3f4f6; }
        .dark .tenant-item:hover { background: #374151; }
        .active-tenant { background: #fffbeb !important; border-left: 4px solid #d97706; }
        .dark .active-tenant { background: rgba(217, 119, 6, 0.12) !important; border-left-color: #f59e0b; }
        .tenant-avatar { width: 36px; height: 36px; border-radius: 50%; background: #fef3c7; color: #92400e; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0; }
        .dark .tenant-avatar { background: #78350f; color: #fde68a; }
        .tenant-info { flex: 1; min-width: 0; }
        .tenant-row { display: flex; justify-content: space-between; align-items: center; }
        .tenant-name { font-size: 14px; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dark .tenant-name { color: #f9fafb; }
        .tenant-time { font-size: 11px; color: #9ca3af; }
        .tenant-preview { font-size: 12px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 80%; }
        .dark .tenant-preview { color: #9ca3af; }
        .chat-badge { background: #ef4444; color: #ffffff; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 10px; }
        .chat-main { flex: 1; display: flex; flex-direction: column; background: #f8fafc; }
        .dark .chat-main { background: #0f172a; }
        .chat-header { padding: 14px 20px; background: #ffffff; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; }
        .dark .chat-header { background: #111827; border-color: #1f2937; }
        .header-profile { display: flex; align-items: center; gap: 12px; }
        .header-profile h3 { font-size: 15px; font-weight: 700; color: #111827; margin: 0; }
        .dark .header-profile h3 { color: #f9fafb; }
        .status-online { font-size: 11px; color: #10b981; display: flex; align-items: center; gap: 4px; font-weight: 500; margin: 0; }
        .dot { width: 6px; height: 6px; background: #10b981; border-radius: 50%; display: inline-block; }
        .btn-delete-chat { color: #9ca3af; background: none; border: none; cursor: pointer; transition: color 0.2s; }
        .btn-delete-chat:hover { color: #ef4444; }
        .chat-body { flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; }
        .message-row { display: flex; width: 100%; margin-bottom: 8px; }
        .row-own { justify-content: flex-end; }
        .row-other { justify-content: flex-start; }
        .bubble { max-width: 65%; padding: 10px 14px; border-radius: 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); position: relative; }
        .bubble-own { background: #d97706; color: #ffffff; border-top-right-radius: 2px; }
        .bubble-other { background: #ffffff; color: #1f2937; border-top-left-radius: 2px; border: 1px solid #e5e7eb; }
        .dark .bubble-other { background: #1f2937; color: #f9fafb; border-color: #374151; }
        .bubble-text { font-size: 13.5px; line-height: 1.5; margin: 0; word-break: break-word; }
        .bubble-name { font-size: 11px; font-weight: bold; margin-bottom: 4px; color: #d97706; }
        .dark .bubble-name { color: #f59e0b; }
        .bubble-time { display: block; text-align: right; font-size: 10px; margin-top: 4px; opacity: 0.7; }
        .chat-footer { padding: 16px; background: #ffffff; border-top: 1px solid #e5e7eb; }
        .dark .chat-footer { background: #111827; border-color: #1f2937; }
        .form-send { display: flex; gap: 12px; }
        .form-send input { flex: 1; padding: 10px 16px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 14px; outline: none; background: #f9fafb; }
        .dark .form-send input { background: #1f2937; border-color: #374151; color: #ffffff; }
        .form-send input:focus { border-color: #d97706; box-shadow: 0 0 0 2px rgba(217, 119, 6, 0.1); }
        .form-send button { background: #d97706; border: none; color: #ffffff; padding: 0 20px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.2s; }
        .form-send button:hover { background: #b45309; }
        .form-send button:disabled { background: #9ca3af; cursor: not-allowed; }
        .chat-empty-board { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #9ca3af; text-align: center; height: 100%; }
        .chat-empty-board svg { margin-bottom: 16px; opacity: 0.4; }
        .chat-empty-board .title { font-size: 16px; font-weight: 700; color: #4b5563; margin: 0; }
        .dark .chat-empty-board .title { color: #9ca3af; }
        .chat-empty-board .subtitle { font-size: 13px; margin-top: 4px; max-width: 320px; }
        .empty-text { text-align: center; padding: 30px 10px; font-size: 13px; color: #9ca3af; }
    </style>

    <script>
        let currentChatId = null;
        let chatsData = [];
        let pollingInterval = null;

        // DOM Elements
        const chatListEl = document.getElementById('chat-list');
        const messagesEl = document.getElementById('chat-messages');
        const headerEl = document.getElementById('chat-header');
        const footerEl = document.getElementById('chat-footer');
        const emptyBoardEl = document.getElementById('empty-state-board');
        const inputEl = document.getElementById('chat-input');
        const sendBtnEl = document.getElementById('chat-send-btn');
        const partnerNameEl = document.getElementById('chat-partner-name');
        const activeAvatarEl = document.getElementById('active-avatar-text');

        // Helpers
        const getCSRF = () => document.querySelector('meta[name="csrf-token"]')?.content || '';
        const getMyUserId = () => parseInt(document.querySelector('meta[name="user-id"]')?.content || 0);
        const scrollToBottom = () => { messagesEl.scrollTop = messagesEl.scrollHeight; };
        const escapeHtml = (unsafe) => (unsafe || '').toString().replace(/[&<"'>]/g, (m) => ({'&': '&amp;','<': '&lt;','>': '&gt;','"': '&quot;',"'": '&#039;'})[m]);

        // 1. Memuat Daftar Chat Panel Kiri (Memanggil endpoint /chat/staff)
        async function fetchChatList() {
            try {
                const response = await fetch('/chat/staff', {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': getCSRF() }
                });
                if (!response.ok) throw new Error('Network error');
                
                const data = await response.json();
                chatsData = data.chats || [];
                renderChatList();
            } catch (error) {
                console.error("Failed to load chat list:", error);
            }
        }

        // 2. Merender HTML Daftar Chat Kiri
        function renderChatList() {
            if (chatsData.length === 0) {
                chatListEl.innerHTML = '<div class="empty-text">No conversations yet.</div>';
                return;
            }

            chatListEl.innerHTML = chatsData.map(chat => `
                <div class="tenant-item ${currentChatId === chat.id ? 'active-tenant' : ''}" onclick="openChat(${chat.id})">
                    <div class="tenant-avatar">${escapeHtml(chat.partner_initials)}</div>
                    <div class="tenant-info">
                        <div class="tenant-row">
                            <span class="tenant-name">${escapeHtml(chat.partner_name)}</span>
                            <span class="tenant-time">${escapeHtml(chat.last_message_time)}</span>
                        </div>
                        <div class="tenant-row" style="margin-top: 4px;">
                            <span class="tenant-preview">${escapeHtml(chat.last_message_preview) || 'No messages yet...'}</span>
                            ${chat.unread_count > 0 ? `<span class="chat-badge">${chat.unread_count}</span>` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // 3. Membuka Chat Tertentu & Memuat Historinya
        async function openChat(tenantId) {
            currentChatId = tenantId;
            const chatData = chatsData.find(c => c.id === tenantId);
            
            if(chatData) {
                partnerNameEl.textContent = chatData.partner_name;
                activeAvatarEl.textContent = chatData.partner_initials;
                headerEl.style.visibility = 'visible';
                footerEl.style.visibility = 'visible';
            }
            
            renderChatList(); // Update highlight
            await fetchMessages(); // Ambil history
            inputEl.focus();
        }

        // 4. Fetch History Messages (Memanggil endpoint /chat/{id}/messages)
        async function fetchMessages() {
            if (!currentChatId) return;
            try {
                const response = await fetch(`/chat/${currentChatId}/messages`, {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': getCSRF() }
                });
                const data = await response.json();
                renderMessages(data.messages || []);
            } catch (error) {
                console.error("Failed to load message history:", error);
            }
        }

        // 5. Render Gelembung Chat
        function renderMessages(messages) {
            if (messages.length === 0) {
                messagesEl.innerHTML = `<div class="empty-text" style="margin: auto;">No messages yet. Send the first one!</div>`;
                return;
            }

            const myId = getMyUserId();
            messagesEl.innerHTML = messages.map(msg => {
                const isOwn = parseInt(msg.sender_id) === myId;
                return `
                    <div class="message-row ${isOwn ? 'row-own' : 'row-other'}">
                        <div class="bubble ${isOwn ? 'bubble-own' : 'bubble-other'}">
                            ${!isOwn ? `<div class="bubble-name">${escapeHtml(msg.sender_name)}</div>` : ''}
                            <p class="bubble-text">${escapeHtml(msg.message)}</p>
                            <span class="bubble-time">${escapeHtml(msg.formatted_time)}</span>
                        </div>
                    </div>
                `;
            }).join('');
            
            scrollToBottom();
        }

        // 6. Mengirim Pesan Baru
        async function sendStaffMessage(e) {
            e.preventDefault();
            const message = inputEl.value.trim();
            if (!message || !currentChatId) return;

            inputEl.value = '';
            inputEl.disabled = true;
            sendBtnEl.disabled = true;

            try {
                const response = await fetch(`/chat/${currentChatId}/message`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': getCSRF() },
                    body: JSON.stringify({ message: message })
                });

                if (response.ok) {
                    await fetchMessages(); // Reload history
                    await fetchChatList(); // Update last message di panel kiri
                }
            } catch (error) {
                alert('Failed to send message. Check your connection.');
            } finally {
                inputEl.disabled = false;
                sendBtnEl.disabled = false;
                inputEl.focus();
            }
        }

        // 7. Hapus Obrolan
        document.getElementById('clear-chat-btn').addEventListener('click', async () => {
            if(!currentChatId || !confirm('Delete this entire chat history?')) return;
            
            try {
                const response = await fetch(`/chat/${currentChatId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': getCSRF() }
                });
                
                if(response.ok) {
                    currentChatId = null;
                    headerEl.style.visibility = 'hidden';
                    footerEl.style.visibility = 'hidden';
                    messagesEl.innerHTML = emptyBoardEl.outerHTML; // Kembalikan ke state kosong
                    fetchChatList();
                }
            } catch (error) {
                alert('Failed to delete conversation.');
            }
        });

        // 8. Auto-Refresh (Polling) setiap 3 Detik
        function startPolling() {
            fetchChatList();
            pollingInterval = setInterval(() => {
                fetchChatList();
                if (currentChatId) fetchMessages();
            }, 3000);
        }

        // Inisialisasi saat Halaman Dimuat
        document.addEventListener('DOMContentLoaded', startPolling);
    </script>
</x-filament-panels::page>