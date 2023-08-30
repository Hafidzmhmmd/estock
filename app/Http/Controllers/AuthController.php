<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        if ($request->username && $request->password) {
            $user = User::where('username', $request->username)->first();
            if($user){
                $hash = Hash::check($request->password, $user->password, []);
                if($hash){
                    Auth::login($user);
                    return response()->json([
                        'status' => true,
                        'url' => route('dashboard')
                    ]);
                }
                else {
                    return response()->json([
                        'status' => false,
                        'msg' => 'password salah'
                    ]);
                }
            }
        }
        else {
            return response()->json([
                'status' => false,
                'msg' => 'Detail login salah'
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
