<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
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

    public function destroy($id)
    {
        $photo = Photo::find($id); // Предположим, что у вас есть модель Photo
        if ($photo) {
            // Удаляем файл из папки uploads
            unlink(public_path('uploads/' . $photo->filename));

            // Удаляем запись из базы данных
            $photo->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function rename(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        // Получаем новое имя из запроса
        $newFilename = $request->input('filename');

        // Добавляем расширение файла, если оно отсутствует
        if (!pathinfo($newFilename, PATHINFO_EXTENSION)) {
            $newFilename .= '.' . pathinfo($photo->filename, PATHINFO_EXTENSION);
        }

        // Переименовываем файл на сервере
        $oldPath = public_path('uploads/' . $photo->filename);
        $newPath = public_path('uploads/' . $newFilename);
        if (file_exists($oldPath)) {
            rename($oldPath, $newPath);
        }

        // Обновляем запись в базе данных
        $photo->filename = $newFilename;
        $photo->save();

        return response()->json([
            'success' => true,
            'newFilename' => $newFilename
        ]);
    }
}
