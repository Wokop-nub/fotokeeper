<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\User;
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

    public function album(string $alias = null): View
    {
        $parent = Album::query()
            ->where('user_id', Auth::user()->id)
            ->where('alias', $alias)
            ->first();
        $albums = $parent->child()->get();
        $photos = $parent->photos()->get();

        return view('album', ['parent' => $alias, 'albums' => $albums, 'photos' => $photos]);
    }

    public function upload(): View
    {
        return view('upload');
    }
}
