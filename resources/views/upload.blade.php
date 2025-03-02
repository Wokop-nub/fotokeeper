@extends('block/pattern')
@section('title')Фотографии@endsection
@section('links')
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/gallery.css">
    <script defer src="/js/gallery/calendar.js"></script>
    <script defer src="/js/gallery/grid.js"></script>
    <script defer src="/js/gallery/context-menu.js"></script>
    <script defer src="/js/modal.js"></script>
@endsection

@section('mainContent')
    @include('block/header', [
        'active'=>1
    ])
    <main class="main">
        <div>
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
            <form id="upload-form" action="/api/photo/upload" method="POST" enctype="multipart/form-data">
                <input type="file" id="photo-upload" name="photo" accept="image/*" style="display: none" onchange="this.form.submit()"/>
                <label class="upload-button" type="button" for="photo-upload">загрузить</label>
            </form>
        </div>

        <div class="grid-container">
            @isset($photos)
                @foreach ($photos as $photo)
                    <div class="photo"
                        oncontextmenu="return false;"
                        style="background-image: url('/storage/uploads/{{$photo->filename}}')"
                    >
                        <img src="/storage/uploads/{{$photo->filename}}" alt="Photo" data-photo-id="{{ $photo->id }}"
                            data-filename="{{ $photo->filename }}">
                        {{-- <div class="custom-tooltip">{{ pathinfo($photo->filename, PATHINFO_FILENAME) }}</div> --}}
                    </div>
                @endforeach
            @endisset
        </div>

        <div id="context-menu">
            <button class="context-menu-btn openModalBtn" data-modal="delete-photo-modal">удалить</button>
            {{-- <button id="rename-button" class="context-menu-btn">переименовать</button> --}}
        </div>

        <div class="modalka" id="delete-photo-modal">
            <form action="/api/album/rename" method="POST" id="delete-photo">
                <button type="submit">Удалить</button>
            </form>
        </div>

    </main>
@endsection
