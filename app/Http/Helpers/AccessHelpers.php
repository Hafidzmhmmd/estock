<?php

namespace App\Http\Helpers;
use Illuminate\Support\Facades\Auth;


class AccessHelpers {
    public static function isPemohon() : bool
    {
        $user = Auth::user();
        return in_array($user->role,config('app.akses.pemohon'));
    }

    public static function isPPK() : bool
    {
        $user = Auth::user();
        return in_array($user->role,config('app.akses.ppk'));
    }

    public static function isPengelolaBMN() : bool
    {
        $user = Auth::user();
        return in_array($user->role,config('app.akses.gudangall'));
    }

    public static function isPPSPM() : bool
    {
        $user = Auth::user();
        return in_array($user->role,config('app.akses.ppspm'));
    }

    public static function isAdmin() : bool
    {
        $user = Auth::user();
        return in_array($user->role,config('app.akses.admin'));
    }
    
    public static function isSuperAdmin() : bool
    {
        $user = Auth::user();
        return in_array($user->role,config('app.akses.superadmin'));
    }
}
