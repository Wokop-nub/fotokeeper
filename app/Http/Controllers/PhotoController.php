<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    // Отображение списка фотографий
    public function index()
    {
        $photos = Photo::latest()->get(); // Загружаем все фотографии из базы
        return view('index', compact('photos')); // Передаем их в шаблон
    }

    // Обработка загрузки фотографий
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ограничиваем тип файла
        ]);

        // Сохранение файла на сервере
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);

        // Сохранение данных в базе
        $photo = new Photo();
        $photo->filename = $filename;
        $photo->save();

        return redirect('/index')->with('success', 'Фотография успешно загружена!');
    }
}
