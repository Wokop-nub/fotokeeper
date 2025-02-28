<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
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

    public function rename(Request $request): Response
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
        ]);

        $album = Album::find($request->id);
        $album->update($request->only('name'));

        return response(['status' => true]);
    }

    public function moveToTrash(Request $request): Response
    {
        $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $album = Album::query()
            ->where('id', $request->id)
            ->where('user_id', $user->id)
            ->first();

        $album->update([
            'parent_id' => $user->trashId()
        ]);

        return response(['status' => true]);
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

        return response(['status' => false, 'message' => 'Фото не загружено.']);
    }
}
