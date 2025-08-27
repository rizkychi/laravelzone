<?php

namespace App\Http\Middleware;

use App\Models\Resource;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class EnsureResourceAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $current = Route::current();
        if (! $current) {
            return $next($request);
        }
        
        $name = $current->getName();
        $action = $current->getActionName();
        $stack  = $current->gatherMiddleware();

        // 1) BYPASS untuk route guest (login/register dll)
        if (in_array('guest', $stack, true)) {
            return $next($request);
        }

        // 2) WHITELIST nama/prefix auth Breeze agar tidak di-cek resource
        //    (route-route ini memang tidak kita sync sebagai resource)
        $whitelistExact = [
            'login', 'logout', 'register', 'dashboard'
        ];
        $whitelistPrefixes = [
            'password.',       // password.request, password.email, password.reset, password.store, password.update, password.confirm
            'verification.',   // verification.notice, verification.send, verification.verify
            'profile.'        // profile.show, profile.edit, profile.update
        ];

        if ($name && (in_array($name, $whitelistExact, true) ||
            Str::startsWith($name, $whitelistPrefixes))) {
            return $next($request);
        }

        // 3) Jika user belum login, jangan cek resource (biar auth middleware yg kerja)
        if (! auth()->check()) {
            return $next($request);
        }

        // 4) Bypass role Superadmin
        if (auth()->user()->hasRole('superadmin')) {
            return $next($request);
        }

        // 5) Ambil resource dari DB (berdasar route_name atau action)
        $resource = Resource::where('route_name', $name)
            ->orWhere('action', $action)
            ->first();

        // === KEBIJAKAN AUTO-DENY ===
        // Kalau kamu MAU auto-deny utk route terproteksi yg belum terdaftar:
        if (! $resource) {
            abort(403, 'Resource belum terdaftar (silakan Sync).');
        }

        if (! $resource->is_active) {
            abort(403, 'Resource non-aktif.');
        }

        // 6) Cek permission
        $perm = $resource->permission_name;
        if ($perm && ! auth()->user()->can($perm)) {
            abort(403, 'Tidak punya akses ke resource ini.');
        }

        return $next($request);
    }
}
