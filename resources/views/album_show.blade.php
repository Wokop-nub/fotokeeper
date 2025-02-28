@extends('block/pattern')
@section('title'){{ $album->name }}@endsection
@section('links')
@endsection

@section('mainContent')
    @include('block/header')
    <main class="main">
        <h1>{{ $album->name }}</h1>

        <!-- Список фотографий в альбоме -->
        <div class="photos">
            @if ($photos->isEmpty())
                <p>В этом альбоме пока нет фотографий.</p>
            @else
                @foreach ($photos as $photo)
                    <div class="photo">
                        <img src="/uploads/{{$photo->filename}}" alt="Photo">
                        <p>{{ $photo->name }}</p>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Кнопка для возврата к списку альбомов -->
        <a href="/album" class="back-button">Вернуться к альбомам</a>
    </main>
@endsection
