<?php

namespace App\Http\Controllers;

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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Сохранение файла на сервере
        $file = $request->file('photo');
        $path = $file->store('uploads', 'public');

        // Сохранение данных в базе
        Photo::create([
            'user_id' => Auth::id(),
            'filename' => basename($path)
        ]);

        return redirect('/upload')->with('success', 'Фотография успешно загружена!');
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
