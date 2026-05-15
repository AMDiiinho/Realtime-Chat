<!DOCTYPE html>
<html>
<head>
    <title>Teste Reverb</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>
</head>
<body>
    <h1>Teste de Canais Reverb</h1>

    <div id="messages"></div>

    <script>
        console.log('Script carregou');

        console.log('Pusher:', window.Pusher);
        console.log('Echo antes:', window.Echo);

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

        console.log('Echo iniciado:', window.Echo);
        console.log('Connector:', window.Echo.connector);

        window.Echo.connector.pusher.connection.bind('connected', () => {
            console.log('WebSocket conectado no Reverb');
        });

        window.Echo.connector.pusher.connection.bind('error', (error) => {
            console.error('Erro no WebSocket:', error);
        });

        window.Echo.private('room.1')
            .subscribed(() => {
                console.log('Conectado ao canal privado room.1');
            })
            .error((error) => {
                console.error('Erro ao conectar no canal privado:', error);
            })
            .listen('MessageSent', (e) => {
                console.log('Mensagem recebida:', e);

                document.getElementById('messages').innerHTML += `
                    <p><strong>${e.user.name}:</strong> ${e.body}</p>
                `;
            });
    </script>
</body>
</html>