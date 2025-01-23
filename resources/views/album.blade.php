<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои альбомы</title>
    <link rel="stylesheet" href="/css/album.css">
</head>

<body>
    <header class="header">
        <img src="/img/logo.svg" alt="logo">
        <nav class="nav">
            <a href="/index" class="nav-link photo-passive"><img src="/img/photo-icon-passive.svg"
                    alt="photo">фотографии</a>
            <a href="{{ route('album.index') }}" class="nav-link albums-acrive">
                <img src="/img/album-icon-active.svg" alt="album">альбомы
            </a>
        </nav>
    </header>

    <main class="main">
        <div class="toolbar">
            <a href="/shared" class="album-svicher"><img src="/img/my-albums.svg" alt="my-albums" style="
                background-color: #4a4a4a;
                border: none; disabled;"></a>
            <button class="create-album-button">создать альбом</button>
        </div>

        <div class="albums">
            @foreach ($albums as $album)
                <a href="{{ route('album.show', $album->id) }}" class="album">
                    <div class="album-thumbnail" data-album="{{ $album->id }}"
                        style="background-image: url('{{ $album->photos->first() ? asset('uploads/' . $album->photos->first()->filename) : '/img/default-album.png' }}');">
                    </div>
                    <div class="album-title">{{ $album->name }}</div>
                </a>
                <!-- Форма удаления альбома -->
                <form action="{{ route('album.destroy', $album->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            @endforeach
        </div>
        <!-- Модальное окно для создания альбома -->
        <div id="create-album-modal" style="display: none;">
            <form action="{{ route('album.store') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Название альбома" required>
                <button type="submit">Создать</button>
            </form>
        </div>

        <!-- Скрипт для открытия/закрытия модального окна -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const createAlbumButton = document.querySelector('.create-album-button');
                const modal = document.getElementById('create-album-modal');
                const closeModalButton = document.getElementById('close-modal');

                createAlbumButton.addEventListener('click', () => {
                    modal.style.display = 'block';
                });

                closeModalButton.addEventListener('click', () => {
                    modal.style.display = 'none';
                });
            });
        </script>
    </main>

    {{-- Скрипт для подстановки последней фотографии --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const albums = document.querySelectorAll('.album-thumbnail');
            albums.forEach(album => {
                const albumId = album.getAttribute('data-album');
                // Здесь можно добавить логику для динамической загрузки последней фотографии
            });
        });
    </script>

</body>

</html>