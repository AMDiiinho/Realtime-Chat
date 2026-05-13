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

        <form action="route{{ '/login.auth' }}" method="POST">

            <label for="user">Login</label>
            <input type="text" name="user" placeholder="Type your username">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Type your password">

            <button type="submit">Sign in</button>
        </form>
    
    </div>

    <a href="/register">Register</a>
</body>
</html>