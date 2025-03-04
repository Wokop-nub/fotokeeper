@extends('block/pattern')
@section('title')Фотографии@endsection
@section('links')
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/gallery.css">
    <script defer src="/js/gallery/calendar.js"></script>
    <script defer src="/js/gallery/provider.js"></script>
    <script defer src="/js/gallery/context-menu.js"></script>
    <script defer type="model" src="/js/modal.js"></script>
    <script defer src="/js/gallery/draggable.js"></script>
@endsection

@section('mainContent')
    @include('block/header', [
        'active'=>1
    ])
    <main class="main">
        <aside>
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
                                <span>С новых фотографий</span>
                            </div>
                            <div class="select-option" data-value="option2">
                                <img src="/img/calendar-old.svg" alt="Option 2" />
                                <span>С старых фотографий</span>
                            </div>
                        </div>
                    </div>
                    <form id="upload-form" action="/api/photo/upload" method="POST" enctype="multipart/form-data">
                        <input type="file" id="photo-upload" name="file[]" accept="image/*" style="display: none" onchange="this.form.submit()" multiple/>
                        <label class="upload-button" type="button" for="photo-upload">загрузить</label>
                    </form>
                </div>

                <ul class="provider">
                    @foreach ($albums as $album)
                        <li>
                            <div class="album-header" data-album-id="{{ $album->id }}">
                                <span class="toggle-icon">▶</span>
                                {{ $album->name }}
                            </div>
                            <div class="hidden">
                                @if (isset($album->child) && count($album->child) > 0)
                                    @include('block.albumTree', ['albums' => $album->child])
                                @endif
                                @if ($album->photos && count($album->photos) > 0)
                                    <ul class="album-photos">
                                        @foreach ($album->photos as $photo)
                                            <li><img
                                                src="/storage/uploads/{{ $photo->filename }}"
                                                alt=""
                                                data-photo-id="{{$photo->id}}"
                                                draggable="true"
                                            ></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <div class="grid-container">
            @isset($photos)
                @foreach ($photos as $photo)
                    <div class="photo"
                        oncontextmenu="return false;"
                        style="background-image: url('/storage/uploads/{{$photo->filename}}')"
                        data-photo-id="{{$photo->id}}"
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
