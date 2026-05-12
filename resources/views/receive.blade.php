<!DOCTYPE html>
<html>
<head>
    <title>Teste Reverb</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <h2>Aguardando mensagens...</h2>
    <div id="messages"></div>

    <script type="module">
        console.log('Echo carregado:', window.Echo);

        window.Echo.channel('chat')
            .listen('MessageSent', (e) => {
                console.log('Evento recebido:', e);

                document.getElementById('messages').innerHTML +=
                    `<p>✅ ${e.message}</p>`;
            });
    </script>
</body>
</html>