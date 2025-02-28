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
    public function create(Request $request): Response
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent' => 'nullable|string|max:255',
        ]);

        if ($request->has('parent')) {
            $check = Album::query()
                ->where('user_id', Auth::id())
                ->where('alias', $request->parent)
                ->get()
                ->flatMap(function ($album) {
                    return $album->child;
                })
                ->pluck('alias')
                ->toArray();
        } else {
            $check = Album::query()
                ->where('user_id', Auth::id())
                ->whereNull('parent_id')
                ->get()
                ->pluck('alias')
                ->toArray();
        }
        $alias = Str::slug($request->name);

        if (in_array($alias, $check))
            return response(['status' => false, 'massage' => 'такоЙ альбом уже есть в этом альбоме'], 400);

        $parent_id = null;
        if ($request->has('parent')) {
            $parent_id = Album::query()
                ->where('user_id', Auth::id())
                ->where('alias', $request->parent)
                ->first()
                ->id;
        }

        Album::create([
            'name' => $request->name,
            'alias' => $alias,
            'user_id' => Auth::user()->id,
            'parent_id' => $parent_id
        ]);

        return response(['status' => true]);
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

        $user = User::find(Auth::id());
        $album = Album::query()
            ->where('id', $request->id)
            ->where('user_id', $user->id)
            ->first();

        $album->update([
            'parent_id' => $user->trashId()
        ]);

        return response(['status' => true]);
    }

    public function uploadPhoto(Request $request): Response
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'file.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Максимальный размер 2 МБ
        ]);

        $album = Album::find($request->id);
        foreach ($request->file('file') as $file) {
            // Сохраняем файл в папку storage/app/public/uploads
            $path = $file->store('uploads', 'public');

            // Создаем запись о файле в базе данных
            $album->photos()->create([
                'filename' => basename($path), // Сохраняем имя файла
            ]);
        }
        return response(['status' => true]);
    }
}
