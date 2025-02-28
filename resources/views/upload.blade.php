@extends('block/pattern')
@section('title')Фотографии@endsection
@section('links')
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/gallery.css">
    <script src="/js/calendar.js"></script>
    <script src="/js/grid.js"></script>
    <script src="/js/upload.js" defer></script>
    <script src="/js/context-menu.js"></script>
@endsection

@section('mainContent')
    @include('block/header')
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
                    <img src="/uploads/{{$photo->filename}}" alt="Photo" data-photo-id="{{ $photo->id }}"
                        data-filename="{{ $photo->filename }}">
                    <div class="custom-tooltip">{{ pathinfo($photo->filename, PATHINFO_FILENAME) }}</div>
                </div>
            @endforeach
            <div id="context-menu">
                <button id="delete-button" class="context-menu-btn">удалить</button>
                <button id="rename-button" class="context-menu-btn">переименовать</button>
            </div>
            <div id="rename-form-container">
                <form id="rename-form" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" id="new-filename" name="filename" placeholder="Введите новое имя">
                    <button type="submit">Сохранить</button>
                    <button type="button" id="cancel-rename">Отмена</button>
                </form>
            </div>
        </div>

    </main>
@endsection
