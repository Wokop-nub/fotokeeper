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
    public function rename(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $album = Album::findOrFail($id);
        $album->name = $request->input('name');
        $album->save();

        return response()->json(['success' => true]);
    }

    // Перемещение альбома в корзину
    public function moveToTrash(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        $album->is_trashed = true; // Предположим, что у вас есть поле is_trashed в таблице albums
        $album->save();

        return response()->json(['success' => true]);
    }

    // Загрузка фотографии
    public function uploadPhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Максимальный размер 2 МБ
        ]);

        if ($request->hasFile('photo')) {
            $album = Album::findOrFail($id);
            $path = $request->file('photo')->store('uploads', 'public'); // Сохраняем фото в папку storage/app/public/uploads

            // Сохраняем информацию о фото в базе данных
            $album->photos()->create([
                'filename' => basename($path),
                'path' => $path,
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Фото не загружено.']);
    }
}
