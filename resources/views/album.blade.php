@extends('block/pattern')
@section('title')Мои альбомы@endsection
@section('links')
    <link rel="stylesheet" href="/css/album-context-menu.css">
    <script type="module" defer src="/js/modal.js"></script>
    <script type="module" defer src="/js/album/album-context-menu.js"></script>
    <script type="module" defer src="/js/album/album-delete-btn.js"></script>
    <script type="module" defer src="/js/album/album-rename-btn.js"></script>
    <script type="module" defer src="/js/album/album-rename-btn.js"></script>
@endsection

@section('mainContent')
    @include('block/header')
    <main class="main">
        <div class="toolbar">
            <button class="create-album-button openModalBtn" data-modal="create-album-modal">создать альбом</button>
        </div>

        <div class="albums">
            @if (!isset($trashAlbum) and $albums->isEmpty() and (!isset($photos) or $photos->isEmpty()))
                <p>В этом альбоме пока пусто</p>
            @else
                @foreach ($albums as $album)
                    <div class="album" data-album-id="{{ $album->id }}">
                        <a href="/album/{{$album->alias}}">
                            <div class="album-thumbnail"
                                style="background-image: url('{{ $album->photos->first() ? asset('uploads/' . $album->photos->first()->filename) : '/img/default-album.svg' }}');">
                            </div>
                            <div class="album-title">{{ $album->name }}</div>
                        </a>
                    </div>
                @endforeach

                @isset($photos)
                    @foreach ($photos as $photo)
                        <div class="photo">
                            <img src="{{ asset('uploads/' . $photo->filename) }}" alt="Photo">
                            <p>{{ $photo->name }}</p> <!-- Название фотографии -->
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
            <form action="/api/album/create" method="POST">
                <input type="text" name="name" placeholder="Название альбома" required>
                @isset($parent)
                    <input type="hidden" name="parent" value="{{$parent}}" readonly>
                @endisset
                <button type="submit">Создать</button>
            </form>
        </div>
    </main>
@endsection
