<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status !== 'active') {
            $status = Auth::user()->status;
            Auth::logout();

            $message = $status === 'pending'
                ? 'Akun Anda sedang menunggu persetujuan Admin. Silakan hubungi Admin atau tunggu notifikasi lebih lanjut.'
                : 'Akun Anda telah dinonaktifkan. Silakan hubungi dukungan jika ini adalah kesalahan.';

            return redirect()->route('login')->with('error', $message);
        }

        return $next($request);
    }
}
