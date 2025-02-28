<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    // Создание нового альбома
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent' => 'nullable|string|max:255',
        ]);

        $parent_id = null;
        if ($request->has('parent')) {
            $parent_id = Album::query()
                ->where('alias', $request->parent)
                ->first()
                ->id;
        }

        Album::create([
            'name' => $request->name,
            'alias' => Str::slug($request->name),
            'user_id' => Auth::user()->id,
            'parent_id' => $parent_id
        ]);

        return redirect('/')->with('success', 'Альбом создан успешно!');
    }

    public function rename(Request $request, $id): Response
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $album = Album::find($id);
        $album->update($request->only('name'));

        return response(['success' => true]);
    }

    public function moveToTrash(Request $request, $id): Response
    {
        $album = Album::findOrFail($id);
        $album->is_trashed = true; // Предположим, что у вас есть поле is_trashed в таблице albums
        $album->save();

        return response(['success' => true]);
    }

    public function uploadPhoto(Request $request, $id): Response
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
            ]);

            return response(['success' => true]);
        }

        return response(['success' => false, 'message' => 'Фото не загружено.']);
    }
}
