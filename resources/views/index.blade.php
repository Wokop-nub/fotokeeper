<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фотографии</title>
    <link rel="stylesheet" href="/css/index.css">
    <script src="/js/calendar.js"></script>
    <script src="/js/grid.js"></script>
    <script src="/js/upload.js" defer></script>
    <link rel="stylesheet" href="/css/gallery.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/context-menu.js"></script>
</head>

<body>
    <header class="header">
        <img src="/img/logo.svg" alt="logo">
        <nav class="nav">
            <a href="/index" class="nav-link photo-active"><img src="/img/photo-icon-active.svg"
                    alt="photo">фотографии</a>
            <a href="/album" class="nav-link albom-passive"><img src="/img/album-icon-passive.svg"
                    alt="albom">альбомы</a>
        </nav>
    </header>

    <main class="main">
        <div class="toolbar">
            <div class="custom-select">
                <!-- Картинка, на которую нажимаем -->
                <div class="select-toggle">
                    <img id="selected-image" src="/img/calendar-icon.svg" alt="Selected" />
                </div>
                <!-- Выпадающий список -->
                <div class="select-dropdown">
                    <div class="select-option" data-value="option1">
                        <img src="/img/calendar-new.svg" alt="Option 1" />
                        <span>Обычный</span>
                    </div>
                    <div class="select-option" data-value="option2">
                        <img src="/img/calendar-old.svg" alt="Option 2" />
                        <span>произвольный</span>
                    </div>
                </div>
            </div>
            <div class="custom-select-grid">
                <!-- Картинка, на которую нажимаем -->
                <div class="select-toggle-grid">
                    <img id="selected-image-grid" src="/img/grid-icon.svg" alt="Selected-grid" />
                </div>
                <!-- Выпадающий список -->
                <div class="select-dropdown-grid">
                    <div class="select-option-grid" data-value="option3">
                        <img src="/img/grid-normal.svg" alt="Option 3" />
                        <span>С новых фотографий</span>
                    </div>
                    <div class="select-option-grid" data-value="option4">
                        <img src="/img/grid-arbitrarily.svg" alt="Option 4" />
                        <span>С старых фотографий</span>
                    </div>
                </div>
            </div>
        </div>
        <form id="upload-form" action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="file" id="photo-upload" name="photo" accept="image/*"
                style="height: 0; width: 0; opacity: 0;" />

            <button class="upload-button" type="button">загрузить</button>


        </form>

        <div class="grid-container">
            @foreach ($photos as $photo)
                <div class="photo-item" oncontextmenu="return false;">
                    <img src="{{ asset('uploads/' . $photo->filename) }}" alt="Photo" data-photo-id="{{ $photo->id }}">
                </div>
            @endforeach
            <div id="context-menu"
                style="display: none; position: absolute; background: white; border: 1px solid #ccc; padding: 10px;">
                <button id="delete-button">Удалить</button>
            </div>
        </div>

    </main>


</body>

</html>