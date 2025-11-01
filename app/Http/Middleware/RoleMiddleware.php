<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
         if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Cek apakah role user sesuai dengan yang diizinkan
        if (!in_array($user->role, $roles)) {
            return redirect()->route('login')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
