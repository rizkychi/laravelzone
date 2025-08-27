<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class MenuTreeService
{
    public function forUser(User $user): array
    {
        $key = $this->cacheKey($user->id);

        return Cache::rememberForever($key, function () use ($user) {
            // eager load anak2 (2 level; tambah kalau perlu)
            $roots = Menu::with('children.children')
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();

            // filter menurut permission user
            return $this->buildVisible($roots, $user);
        });
    }

    public static function bustAll(): void
    {
        // Cara sederhana: naikkan versi global agar semua key per-user ikut invalid
        Cache::increment('menu:version'); // default 0 -> 1
    }

    private function cacheKey(string $userId): string
    {
        $ver = Cache::get('menu:version', 1);
        return "menu:user:{$userId}:v{$ver}";
    }

    private function buildVisible($nodes, User $user): array
    {
        $out = [];
        foreach ($nodes as $m) {
            if (!$m->is_active) continue;

            // izin tampil? (jika menu punya permission_name, cek; kalau kosong, bebas untuk user login)
            $canSee = $m->permission_name ? $user->can($m->permission_name) : true;

            // proses anak dulu
            $children = $this->buildVisible($m->children, $user);

            // aturan: folder tanpa permission boleh tampil jika punya anak yang terlihat
            if ($canSee || count($children) > 0) {
                $out[] = [
                    'id'            => $m->id,
                    'title'         => $m->title,
                    'icon'          => $m->icon,
                    'route_name'    => $m->route_name,
                    'url'           => $m->url,
                    'children'      => $children,
                ];
            }
        }
        return $out;
    }
}