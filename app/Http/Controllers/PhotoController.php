<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'file.*' => 'required|image|mimes:jpeg,png,jpg,gif',
            'album' => 'nullable|string|filled'
        ]);

        $album = ($request->has('album')) ?
            Album::query()
            ->where('user_id', Auth::id())
            ->where('alias', $request->album)
            ->first()
            ->id :
            null;


        foreach ($request->file as $file) {
            // Сохранение файла на сервере
            $path = $file->store('uploads', 'public');

            // Сохранение данных в базе
            Photo::create([
                'user_id' => Auth::id(),
                'filename' => basename($path),
                'album_id' => $album
            ]);
        }

        return ($album == null) ?
            redirect('/upload') :
            redirect()->back();
    }

    public function destroy(Request $request): Response
    {
        $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        $photo = Photo::findOrFail($request->id);
        unlink(storage_path('app/public/uploads/' . $photo->filename));
        $photo->delete();

        return response(['status' => true]);
    }
}
