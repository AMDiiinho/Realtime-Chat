<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    
    <h3>Register</h3>

    <div class="register-form">
        <form action="{{ route('user.create') }}" method="POST">

            @csrf

            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Register a username">

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Register your e-mail">

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Create a strong password">

            <button type="submit">Register</button>
        </form>
    </div>

</body>
</html>