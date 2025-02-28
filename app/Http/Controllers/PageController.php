<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('album');
        }
        return view('auth/welcome');
    }

    public function mainAlbum(): View
    {
        $albums = Album::query()
            ->where('user_id', Auth::user()->id)
            ->where('parent_id', null)
            ->whereNot('name', 'Корзина')
            ->get();

        $trash = Album::query()
            ->where('user_id', Auth::user()->id)
            ->where('name', 'Корзина')
            ->first();

        return view('album', ['albums' => $albums, 'trashAlbum' => $trash]);
    }

    public function album(string $path): View
    {
        $segments = explode('/', $path);
        if (count($segments) >= 2) {
            $parent = Album::query()
                ->where('user_id', Auth::id())
                ->where('alias', $segments[0])
                ->first();
            $photos = null;

            for ($i = 1; $i < count($segments); $i++) {
                $parent = $parent->child()
                    ->where('alias', $segments[$i])
                    ->first();
                $albums = $parent->child()->get();
                $photos = $parent->photos()->get();
            }
        } else {
            $parent = Album::query()
                ->where('user_id', Auth::user()->id)
                ->where('alias', $segments[0])
                ->first();
            $albums = $parent->child()->get();
            $photos = $parent->photos()->get();
        }

        return view('album', ['alias' => last($segments), 'albums' => $albums, 'photos' => $photos]);
    }

    public function upload(): View
    {
        return view('upload');
    }
}
