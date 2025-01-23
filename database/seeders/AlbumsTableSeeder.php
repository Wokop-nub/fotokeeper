<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Album;

class AlbumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Создаём альбом "Корзина", если он ещё не существует
        Album::firstOrCreate(
            ['name' => 'Корзина'], // Условие поиска
            ['name' => 'Корзина']  // Данные для создания
        );
    }
}
