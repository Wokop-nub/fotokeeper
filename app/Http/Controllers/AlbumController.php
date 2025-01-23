<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    // Отображение списка альбомов
    public function index()
    {
        // Получаем все альбомы, кроме корзины
        $albums = Album::where('name', '!=', 'Корзина')->with('photos')->get();

        // Получаем альбом "Корзина"
        $trashAlbum = Album::where('name', 'Корзина')->with('photos')->first();

        // Если альбом "Корзина" не существует, создаём его
        if (!$trashAlbum) {
            $trashAlbum = Album::create(['name' => 'Корзина']);
        }

        // Передаём оба набора данных в представление
        return view('album', compact('albums', 'trashAlbum'));
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
        // Перемещаем альбом в корзину
        $trashAlbum = Album::where('name', 'Корзина')->first();
        if ($trashAlbum) {
            $album->update(['album_id' => $trashAlbum->id]);
        }

        return response()->json(['success' => true]);
    }
    public function show(Album $album)
    {
        $photos = $album->photos;
        return view('album_show', compact('album', 'photos')); // Используем album_show.blade.php
    }
    public function update(Request $request, Album $album)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $album->update($request->only('name'));

        return response()->json(['success' => true]);
    }
}
