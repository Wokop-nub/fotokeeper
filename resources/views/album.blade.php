@extends('block/pattern')
@section('title')Мои альбомы@endsection
@section('links')
    <link rel="stylesheet" href="/css/album.css">
    <link rel="stylesheet" href="/css/album-context-menu.css">
    <script type="module" defer src="/js/modal.js"></script>
    <script type="module" defer src="/js/album/album-context-menu.js"></script>
    <script type="module" defer src="/js/album/album-delete.js"></script>
    <script type="module" defer src="/js/album/album-rename.js"></script>
    <script type="module" defer src="/js/album/album-upload.js"></script>
    <script type="module" defer src="/js/album/create.js"></script>
@endsection

@section('mainContent')
    @include('block/header', [
        'active'=>2
    ])
    <main class="main">
        <div class="toolbar">
            @isset($alias)
                <a href="{{ '/' . implode('/', array_slice(explode('/', request()->path()), 0, -1)) }}" class="create-album-button">Назад</a>
                <form id="upload-form" action="/api/photo/upload" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="file" id="photo-upload" name="file[]" accept="image/*" style="display: none" onchange="this.form.submit()" multiple/>
                    <label class="create-album-button" type="button" for="photo-upload">Загрузить фотки</label>
                </form>
            @endisset
            <button class="create-album-button openModalBtn" data-modal="create-album-modal">Cоздать альбом</button>
        </div>

        <div class="albums">
            @if (!isset($trashAlbum) and $albums->isEmpty() and (!isset($photos) or $photos->isEmpty()))
                <p>В этом альбоме пока пусто</p>
            @else
                @foreach ($albums as $album)
                    <div class="album" data-album-id="{{ $album->id }}">
                        <a href="{{ request()->url().'/'.$album->alias }}">
                            <div class="album-thumbnail"
                                style="background-image: url('{{ $album->photos->first() ? '/storage/uploads/' . $album->photos->first()->filename : '/img/default-album.svg' }}');">
                            </div>
                            <div class="album-title">{{ $album->name }}</div>
                        </a>
                    </div>
                @endforeach

                @isset($photos)
                    @foreach ($photos as $photo)
                        <div class="photo"
                            style="background-image: url('/storage/uploads/{{$photo->filename}}')">
                            <img src="/storage/uploads/{{$photo->filename}}" alt="">
                        </div>
                    @endforeach
                @endisset

                @isset($trashAlbum)
                    <div class="album" data-album-id="{{ $trashAlbum->id }}">
                        <a href="/album/{{$trashAlbum->alias}}">
                            <div class="album-thumbnail" style="background-image: url('/img/basket.svg');">
                            </div>
                            <div class="album-title">{{ $trashAlbum->name }}</div>
                        </a>
                    </div>
                @endisset
            @endif
        </div>

        @include('block/albumMenu')

        <!-- Модальное окно для создания альбома -->
        <div class='modalka' id="create-album-modal">
            <form action="/api/album/create" method="POST" id="create-album-form">
                <input type="text" name="name" placeholder="Название альбома" required>
                @isset($alias)
                    <input type="hidden" name="parent" value="{{$alias}}" readonly>
                @endisset
                <button type="submit">Создать</button>
            </form>
        </div>
    </main>
@endsection
