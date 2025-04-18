<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role->role_code) {
            return $next($request);
        }

        switch ($user->role->role_code) {
            case 'ADM':
                return redirect()->route('admin.index');

            case 'MHS':
                return redirect()->route('mahasiswa.index');

            default:
                return redirect()->route('login')->withErrors([
                    'role' => 'You do not have permission to access this page.',
                ])->onlyInput('email');
        }
    }
}
