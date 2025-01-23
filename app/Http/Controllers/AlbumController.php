<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    // Отображение списка альбомов
    public function index()
    {
        $albums = Album::with('photos')->get(); // Получаем все альбомы с фотографиями
        return view('album', compact('albums')); // Передаём переменную $albums в представление
    }

    // Создание нового альбома
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Album::create($request->only('name'));

        return redirect()->route('album.index')->with('success', 'Альбом создан успешно!');
    }

    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('album.index')->with('success', 'Альбом удалён успешно!');
    }
    public function show(Album $album)
    {
        $photos = $album->photos;
        return view('album_show', compact('album', 'photos')); // Используем album_show.blade.php
    }
}
