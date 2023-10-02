<?php
namespace App\Http\Middleware;

use App\Helpers\MenuHelpers;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

class AccessAuth {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

     public function handle(Request $request, Closure $next){
        if (Auth::check()) {
            $user = Auth::user();
            return $next($request);
        } else {
            return redirect()->route('login');
        }
     }
}
