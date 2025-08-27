<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Resource;
use App\Services\MenuTreeService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class MenuSyncController extends Controller
{
    // NOTE: Middleware akses bisa kamu taruh di route atau pakai attribute middleware (Laravel 12)
    // Route example:
    // Route::post('menus/sync', [MenuSyncController::class,'store'])->middleware(['auth','verified'])->name('menus.sync');

    public function store(): RedirectResponse
    {
        // Ambil hanya resource aktif dengan route_name berakhiran ".index"
        // (jika ada resource tanpa route_name, kita skip saja)
        $resources = Resource::query()
            ->where('is_active', true)
            ->whereNotNull('route_name')
            ->get()
            ->filter(fn($r) => Str::endsWith($r->route_name, '.index'));

        $createdOrFound = 0;

        foreach ($resources as $res) {
            $routeName = $res->route_name;           // ex: 'admin.users.index' | 'users.index'
            $segments  = explode('.', $routeName);   // ['admin','users','index']

            // Pastikan segmen terakhir benar-benar 'index'
            $last = array_pop($segments);            // 'index'
            if (strtolower($last) !== 'index') {
                continue; // safety guard
            }

            // Nama resource = segmen terakhir sebelum 'index'
            if (empty($segments)) {
                // kasus edge (unlikely) → lewati
                continue;
            }
            $resourceKey = array_pop($segments);     // ex: 'users'
            $resourceTitle = Str::headline($resourceKey); // 'Users'

            // Sisa segmen di depan adalah prefix/nesting group (sesuai route_name di web.php)
            // Contoh: ['admin'] → Parent "Admin"
            // Contoh: ['backoffice','master'] → Parent "Backoffice" → child "Master" → (leaf 'Users')
            $parentId = $this->ensureParentChain($segments);

            // Buat/temukan leaf menu untuk route index ini
            Menu::firstOrCreate(
                [
                    'route_name' => $routeName,
                    'parent_id'  => $parentId,
                ],
                [
                    'title'           => $resourceTitle,               // tanpa "Index"
                    'icon'            => null,
                    'url'             => null,
                    'order'           => 0,
                    'is_active'       => true,
                    'is_system'       => true,
                    'permission_name' => $res->permission_name,        // cocokkan dgn Resource
                ]
            );

            $createdOrFound++;
        }

        MenuTreeService::bustAll();
        return back()->with('success', "Sync menu selesai. {$createdOrFound} item index terdaftar/terupdate.");
    }

    /**
     * Pastikan chain parent sesuai prefix route_name:
     *  - segments: ['admin','master'] → buat/temukan parent "Admin", lalu child "Master" (tanpa route/url)
     *  - return parent_id terakhir (atau null jika tidak ada segmen)
     */
    protected function ensureParentChain(array $segments): ?int
    {
        if (empty($segments)) return null;

        $parentId = null;
        foreach ($segments as $seg) {
            $title = Str::headline($seg); // 'admin' -> 'Admin'
            $parent = Menu::firstOrCreate(
                [
                    'title'     => $title,
                    'parent_id' => $parentId,
                    'route_name'=> null,      // group: tidak mengarah ke route
                ],
                [
                    'icon'       => null,
                    'url'        => null,
                    'order'      => 0,
                    'is_active'  => true,
                    'is_system'  => true,
                    // permission_name dikosongkan agar jadi “folder” saja
                ]
            );

            $parentId = $parent->id;
        }

        return $parentId;
    }
}
