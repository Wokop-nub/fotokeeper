@extends('block/pattern')
@section('title'){{ $album->name }}@endsection
@section('links')
@endsection

@section('mainContent')
    @include('block/header')
    <main class="main">
        <h1>{{ $album->name }}</h1>

        <div class="photos">
            @foreach ($photos as $photo)
                <div class="photo">
                    <img src="/uploads/{{$photo->filename}}" alt="Photo">
                    <p>{{ $photo->name }}</p>
                </div>
            @endforeach
        </div>
    </main>
    @endsection
