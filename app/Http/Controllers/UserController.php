<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SigninRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller
{
    public function signin(SigninRequest $request): Response
    {
        $data = $request->only([
            'name',
            'email',
        ]);
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        Auth::login($user);

        return response(['status' => true], 200);
    }

    public function login(LoginRequest $request): Response
    {
        $data = $request->only([
            'email',
            'password'
        ]);

        $user = User::query()
            ->where('email',  $data['email'])
            ->first();

        if ($user == null or !Hash::check($data['password'], $user->password))
            return response(['status' => false, 'message' => 'incorrect data'], 404);

        Auth::login($user);

        return response(['status' => true], 200);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }

    public function edit(Request $request): Response
    {
        $data = $request->only([
            'name',
            'email',
        ]);

        $user = User::find(Auth::user()->id);
        $user->update($data);

        return response(['status' => true]);
    }
}
