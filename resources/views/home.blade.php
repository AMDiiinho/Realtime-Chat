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

        <form action="{{ route('room.store') }}" method="POST">

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

    <h2>Join Room</h2>
    <form action="{{ route('room.join') }}" method="POST">

        @csrf

        <input type="text" name="name" placeholder="Room's name">
        <input type="password" name="password" placeholder="password">

        <button type="submit">Join</button>
    </form>

    <h2>My rooms</h2>
    <input type="text" name="search-room" placeholder="Search a room">

    <h2>Private Rooms</h2>

    <div class="rooms-list">
        @foreach ($myRooms as $room)
            <div class="room-item" data-room-name="{{ strtolower($room->name) }}">
                <a href="{{ route('room.index', $room) }}">
                    {{ $room->name }}
                </a>

            </div>
        @endforeach
    </div>

    <h2>Public Rooms</h2>

    <div class="rooms-list">
        @foreach ($publicRooms as $room)
            <div class="room-item" data-room-name="{{ strtolower($room->name) }}">
                <a href="{{ route('room.index', $room) }}">
                    {{ $room->name }}
                </a>
            </div>
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




            const searchInput = document.querySelector('input[name="search-room"]');

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const query = this.value.toLowerCase().trim();
                    const rooms = document.querySelectorAll('.room-item');

                    rooms.forEach(room => {
                        const name = room.dataset.roomName || room.textContent.toLowerCase();

                        room.style.display = query === '' || name.includes(query)
                            ? ''
                            : 'none';
                    });
                });
            }
        });
    </script>
</body>
</html>