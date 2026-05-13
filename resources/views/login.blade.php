<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
    <title>Login</title>
</head>
<body>
    <div class="titulo">
        <h3>Login</h3>
    </div>

    <div class="login-form">

        <form action="route{{ '/login' }}" method="POST">

            <input type="text" name="user" placeholder="login">
            <input type="password" name="password" placeholder="password">

            <button type="submit">Entrar</button>
        </form>
    
    </div>
    
    <button>Cadastrar</button>
</body>
</html>