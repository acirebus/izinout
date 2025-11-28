<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Map route role to actual database role
        $roleMapping = [
            'admin' => 'admin_bk',
            'guru' => 'guru',
            'siswa' => 'student',
            'student' => 'student',
            'admin_bk' => 'admin_bk',
        ];
        $expectedRole = $roleMapping[$role] ?? $role;
        if ($user->role !== $expectedRole) {
            // Redirect to appropriate dashboard based on actual role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif (method_exists($user, 'isGuru') && $user->isGuru()) {
                return redirect()->route('guru.dashboard');
            } elseif (method_exists($user, 'isStudent') && $user->isStudent()) {
                return redirect()->route('student.dashboard');
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}