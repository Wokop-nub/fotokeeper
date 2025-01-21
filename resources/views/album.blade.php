<!DOCTYPE html>
<html lang="en">

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
            <a href="/album" class="nav-link albums-acrive"><img src="/img/album-icon-active.svg"
                    alt="albums">альбомы</a>
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
            <!-- Альбом "Черно-белое" -->
            <a href="album-black-white.html" class="album">
                <div class="album-thumbnail" data-album="black-white" style="background-image: url('/img/gally4.png');">
                </div>
                <div class="album-title">Черно-белое</div>
            </a>
            <!-- Альбом "Природа" -->
            <a href="album-nature.html" class="album">
                <div class="album-thumbnail" data-album="nature" style="background-image: url('/img/gally3.png');">
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

    {{--
    <script>
        // Скрипт для подстановки последней фотографии
        document.addEventListener('DOMContentLoaded', () => {
            const albums = document.querySelectorAll('.album-thumbnail:not(.fixed-thumbnail)');
            albums.forEach(album => {
                const albumType = album.getAttribute('data-album');
                // Подставьте реальную логику загрузки последнего изображения альбома
                let lastPhotoUrl = '';
                switch (albumType) {
                    case 'black-white':
                        lastPhotoUrl = 'black-white.jpg'; // Последняя фотография черно-белого альбома
                        break;
                    case 'nature':
                        lastPhotoUrl = 'nature.jpg'; // Последняя фотография альбома природы
                        break;
                    default:
                        lastPhotoUrl = 'default.jpg'; // Если нет последней фотографии
                }
                album.style.backgroundImage = `url('${lastPhotoUrl}')`;
            });
        });
    </script> --}}
</body>

</html>