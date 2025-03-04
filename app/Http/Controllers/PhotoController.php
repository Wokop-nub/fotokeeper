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
            'id' => 'nullable|integer|min:1'
        ]);

        $album = ($request->has('id')) ?
            Album::query()
            ->where('user_id', Auth::id())
            ->find($request->id)
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

    public function moving(Request $request): Response {
        $request->validate([
            'id' => 'required|integer|min:1',
            'albumId' => 'nullable|integer|min:1'
        ]);

        $photo = Photo::find($request->id);
        if($photo == null)
            return response(['status'=>false, 'message'=>'Photo not found'], 404);

        if($request->has('albumId') and $request->albumId != null){
            if(Album::find($request->albumId) != null){
                $photo->update([
                    'album_id'=>$request->albumId
                ]);
                return response(['status'=>true]);
            }
            else
                return response(['status'=>false, 'message'=>'Album not found'], 404);
        }
        $photo->update([
            'album_id'=>null
        ]);
        return response(['status'=>true]);
    }
}
