@extends('block/pattern')
@section('title')Мои альбомы@endsection
@section('links')
    <link rel="stylesheet" href="/css/album-context-menu.css">
    <script defer src="/js/album-context-menu.js"></script>
    {{-- <script src="/js/album-delete-btn.js"></script> --}}
    {{-- <script src="/js/album-rename-btn.js"></script> --}}
@endsection

@section('mainContent')
    @include('block/header')
    <main class="main">
        <div class="toolbar">
            <button class="create-album-button">создать альбом</button>
        </div>

        <div class="albums">
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

            <!-- Альбом "Корзина" -->
            @isset($trashAlbum)
                <div class="album" data-album-id="{{ $trashAlbum->id }}">
                    <a href="/album/{{$trashAlbum->alias}}">
                        <div class="album-thumbnail" style="background-image: url('/img/basket.svg');">
                        </div>
                        <div class="album-title">{{ $trashAlbum->name }}</div>
                    </a>
                </div>
            @endisset

            <!-- Контекстное меню -->
            <div id="context-menu" style="display: none; position: absolute; background: white; border: 1px solid #ccc; padding: 10px;">
                <button id="add-photo-button">Добавить фотографию</button>

                <button id="rename-album-button">Переименовать альбом</button>
                <button id="delete-album-button">Удалить альбом</button>
            </div>

            <!-- Модальное окно для создания альбома -->
            <div id="create-album-modal" style="display: none;">
                <form action="/api/album/create" method="POST">
                    <input type="text" name="name" placeholder="Название альбома" required>
                    @isset($parent)
                        <input type="hidden" name="parent" value="{{$parent}}" readonly>
                    @endisset
                    <button type="submit">Создать</button>
                </form>
            </div>
        </div>
        <!-- Скрипт для открытия/закрытия модального окна -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const createAlbumButton = document.querySelector('.create-album-button');
                const modal = document.getElementById('create-album-modal');
                const closeModalButton = document.getElementById('close-modal');

                createAlbumButton.addEventListener('click', () => {
                    modal.style.display = 'block';
                });

                closeModalButton.addEventListener('click', () => {
                    modal.style.display = 'none';
                });
            });
        </script>
    </main>

    {{-- Скрипт для подстановки последней фотографии
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const albums = document.querySelectorAll('.album-thumbnail');
            albums.forEach(album => {
                const albumId = album.getAttribute('data-album');
                // Здесь можно добавить логику для динамической загрузки последней фотографии
            });
        });
    </script> --}}
@endsection
