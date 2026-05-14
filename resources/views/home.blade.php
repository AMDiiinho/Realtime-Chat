<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
    <title>Home</title>
</head>
<body>
    <h2>Criar sala de reunião</h2>
    <div class="room-form">

        <form action="{{ route('room.create') }}" method="POST">

            @csrf

            <label for="name">Room name:</label>
            <input type="text" name="name" placeholder="Room's name">

            <input type="radio" id="private" name="type" value="private" checked>
            <label for="private">Private</label>

            <input type="radio" id="public" name="type" value="public">
            <label for="public">Public</label>

            <input type="password" name="password" id="password" placeholder="Room's password" style="display: block;">

            <button type="submit">Create room</button>
        </form>

    </div>

    <div class="rooms-list">

        @foreach ($rooms as $room)
            <a href="#">{{ $room->name }}</a>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const privateRadio = document.getElementById('private');
            const publicRadio = document.getElementById('public');
            const passwordField = document.getElementById('password');

            function togglePasswordField() {

                
                if (privateRadio.checked) {
                    passwordField.style.display = 'block';
                } else {
                    passwordField.style.display = 'none';
                }
            }

            privateRadio.addEventListener('change', togglePasswordField);
            publicRadio.addEventListener('change', togglePasswordField);
            
            privateRadio.checked = 'true'
            togglePasswordField();
        });
    </script>
</body>
</html>