<!DOCTYPE html>
<html>
<head>
    <title>{{ $room->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>
</head>
<body>

    <h1>{{ $room->name }}</h1>

    <div id="messages">
        @foreach ($messages as $message)
            <p data-message-id="{{ $message->id }}">
                <strong>{{ $message->user->username }}:</strong>
                {{ $message->body }}
            </p>
        @endforeach
    </div>

    <form id="message-form">
        <input type="hidden" id="room_id" value="{{ $room->id }}">

        <input 
            type="text" 
            id="body" 
            placeholder="Digite sua mensagem"
            autocomplete="off"
        >

        <button type="submit">Enviar</button>
    </form>

    <script>
        function escapeHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function appendMessage(message) {
            const messagesContainer = document.getElementById('messages');

            if (message.id && document.querySelector(`[data-message-id="${message.id}"]`)) {
                return;
            }

            const userName = message.user?.name ?? message.user?.username ?? 'Usuário';
            const body = message.body ?? '';

            messagesContainer.innerHTML += `
                <p data-message-id="${escapeHtml(message.id)}">
                    <strong>${escapeHtml(userName)}:</strong>
                    ${escapeHtml(body)}
                </p>
            `;
        }

        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env("REVERB_APP_KEY") }}',
            cluster: 'mt1',

            wsHost: '{{ env("REVERB_HOST", "127.0.0.1") }}',
            wsPort: {{ env("REVERB_PORT", 8080) }},
            wssPort: {{ env("REVERB_PORT", 8080) }},

            forceTLS: false,
            encrypted: false,
            disableStats: true,
            enabledTransports: ['ws'],

            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                }
            }
        });

        const roomId = document.getElementById('room_id').value;

        window.Echo.private(`room.${roomId}`)
            .subscribed(() => {
                console.log(`Conectado ao canal privado room.${roomId}`);
            })
            .error((error) => {
                console.error('Erro ao conectar no canal privado:', error);
            })
            .listen('MessageSent', (e) => {
                console.log('Mensagem recebida pelo Reverb:', e);
                appendMessage(e);
            });

        document.getElementById('message-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            const bodyInput = document.getElementById('body');
            const body = bodyInput.value.trim();

            if (!body) {
                return;
            }

            try {
                const response = await fetch('{{ route("messages.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'X-Socket-ID': window.Echo.socketId()
                    },
                    body: JSON.stringify({
                        room_id: roomId,
                        body: body
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    console.error('Erro ao enviar mensagem:', data);
                    return;
                }

                if (data.success) {
                    appendMessage(data.message);
                    bodyInput.value = '';
                }

            } catch (error) {
                console.error('Erro inesperado no envio:', error);
            }
        });
    </script>
</body>
</html>