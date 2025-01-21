<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Общие альбомы</title>
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
        <div class="toolbar">
            <a href="/album" class="album-svicher"><img src="/img/shared.svg" alt="my-albums" style="
                background-color: #4a4a4a;
                border: none; disabled;"></a>
            <button class="create-album-button">создать альбом</button>
        </div>

        <div class="albums">
            <!-- Альбом "Черно-белое" -->

            <!-- Альбом "Природа" -->
            <a href="album-nature.html" class="album">
                <div class="album-thumbnail" data-album="nature" style="background-image: url('/img/shared1.png');">
                </div>
                <div class="album-title">Природа</div>
            </a>
            <!-- Альбом "Корзина" -->
            <a href="album-trash.html" class="album">
                <div class="album-thumbnail fixed-thumbnail" style="background-image: url('/img/basket.svg');">
                </div>
                <div class="album-title">Корзина</div>
            </a>
        </div>
    </main>


</body>

</html>