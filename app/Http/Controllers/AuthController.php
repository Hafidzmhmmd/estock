<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        if ($request->username && $request->password) {
            $user = User::where()
        }
    }
}
