<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $album->name }}</title>
    <link rel="stylesheet" href="/css/album.css">
</head>

<body>
    <header class="header">
        <img src="/img/logo.svg" alt="logo">
        <nav class="nav">
            <a href="/index" class="nav-link photo-passive"><img src="/img/photo-icon-passive.svg"
                    alt="photo">фотографии</a>
            <a href="/album" class="nav-link albums-acrive"><img src="/img/album-icon-active.svg"
                    alt="albums">альбомы</a>
        </nav>
    </header>

    <main class="main">
        <h1>{{ $album->name }}</h1>

        <div class="photos">
            @foreach ($photos as $photo)
                <div class="photo">
                    <img src="{{ asset('uploads/' . $photo->filename) }}" alt="Photo">
                    <p>{{ $photo->name }}</p>
                </div>
            @endforeach
        </div>
    </main>
</body>

</html>