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
            'file.*' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $album = Album::find($request->id);
        foreach ($request->file('file') as $file) {
            $path = $file->store('uploads', 'public');

            // Создаем запись о файле в базе данных
            $album->photos()->create([
                'user_id' => Auth::id(),
                'filename' => basename($path), // Сохраняем имя файла
            ]);
        }
        return response(['status' => true]);
    }

    public function moving(Request $request): Response {
        $request->validate([
            'id' => 'required|integer|min:1',
            'albumId' => 'required|integer|min:1'
        ]);

        $movable = Album::find($request->id);
        if($movable == null)
            return response(['status'=>false, 'message'=>'movable not found'], 404);
        if($movable->name == 'Корзина')
            return response(['status'=>false, 'message'=>'Корзину нельзя перемещать'], 403);

        $target = Album::find($request->albumId);
        if($target == null)
            return response(['status'=>false, 'message'=>'target album not found'], 404);
        if($target->child()->where('alias', $movable->alias)->first() != null)
            return response(['status'=>false, 'message'=>"in target album already exist album with name $movable->name"], 403);

        $movable->update([
            'parent_id' => $target->id
        ]);
        return response(['status'=>true]);
    }
}
