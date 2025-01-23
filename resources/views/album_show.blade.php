<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $album->name }}</title>
    <link rel="stylesheet" href="/css/album.css"> <!-- Подключите ваш CSS-файл -->
</head>

<body>
    <header class="header">
        <img src="/img/logo.svg" alt="logo"> <!-- Логотип -->
        <nav class="nav">
            <a href="/index" class="nav-link photo-passive">
                <img src="/img/photo-icon-passive.svg" alt="photo">фотографии
            </a>
            <a href="{{ route('album.index') }}" class="nav-link albums-acrive">
                <img src="/img/album-icon-active.svg" alt="album">альбомы
            </a>
        </nav>
    </header>

    <main class="main">
        <h1>{{ $album->name }}</h1> <!-- Название альбома -->

        <!-- Список фотографий в альбоме -->
        <div class="photos">
            @if ($photos->isEmpty())
                <p>В этом альбоме пока нет фотографий.</p>
            @else
                @foreach ($photos as $photo)
                    <div class="photo">
                        <img src="{{ asset('uploads/' . $photo->filename) }}" alt="Photo">
                        <p>{{ $photo->name }}</p> <!-- Название фотографии -->
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Кнопка для возврата к списку альбомов -->
        <a href="{{ route('album.index') }}" class="back-button">Вернуться к альбомам</a>
    </main>

    <!-- Скрипты (если нужны) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Здесь можно добавить JavaScript-логику, если требуется
        });
    </script>
</body>

</html>