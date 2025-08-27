<?php

// app/Services/ResourceSyncService.php
namespace App\Services;

use App\Models\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ResourceSyncService
{
    public function sync(): array
    {
        $excludeNamePrefixes = config('resource_sync.exclude_name_prefixes', []);
        $excludeControllerNamespaces = config('resource_sync.exclude_controllers', []);
        $excludeUriPrefixes = config('resource_sync.exclude_uris', []);
        $namedRoutesOnly = config('resource_sync.named_routes_only', true);
        $pruneOrphans = config('resource_sync.prune_orphans', true);

        $routes = collect(Route::getRoutes())
            ->filter(function ($route) use (
                $excludeNamePrefixes, $excludeControllerNamespaces, $excludeUriPrefixes, $namedRoutesOnly) {
                $name   = $route->getName();            // bisa null
                $action = $route->getActionName();      // "Closure" atau "FQCN@method"
                $uri    = $route->uri();

                // 1) buang Closure
                if ($action === 'Closure' || Str::contains($action, 'Closure')) return false;

                // 2) buang route tanpa nama (opsional: jika kamu hanya mau yg bernama)
                //    kalau mau ijinkan yg tanpa nama, hapus blok ini.
                if ($namedRoutesOnly && empty($name)) return false;

                // 3) buang prefix nama auth (login, password.*, verification.*, dst.)
                if ($name && Str::startsWith($name, $excludeNamePrefixes)) return false;

                // 4) buang controller di namespace Auth
                foreach ($excludeControllerNamespaces as $ns) {
                    if (Str::startsWith($action, $ns)) return false;
                }

                // 5) buang uri internal/panel debug
                foreach ($excludeUriPrefixes as $prefix) {
                    if (Str::startsWith($uri, $prefix)) return false;
                }

                // 6) pastikan ini route web (bukan api)
                $middleware = $route->gatherMiddleware();
                return in_array('web', $middleware, true);
            });

        $created = 0; $updated = 0; $deleted = 0;
        $seenPerms = [];

        DB::transaction(function () use ($routes, &$created, &$updated, &$deleted, &$seenPerms, $pruneOrphans) {
            foreach ($routes as $r) {
                $name   = $r->getName();
                $action = $r->getActionName();
                $method = implode('|', $r->methods());
                $uri    = $r->uri();

                // gunakan route name sbg identitas; fallback ke action jika named_routes_only=false
                $key    = $name ?: $action;
                $perm   = 'access '.$key;
                $seenPerms[] = $perm;

                $data = [
                    'name'       => Str::headline($name ?: class_basename($action)),
                    'route_name' => $name,
                    'action'     => $action,
                    'method'     => $method,
                    'uri'        => $uri,
                ];

                $res = Resource::where('permission_name',$perm)->first();
                if ($res) {
                    $res->fill($data);
                    if ($res->isDirty()) { $res->save(); $updated++; }
                } else {
                    Resource::create($data + ['permission_name'=>$perm, 'is_active'=>true]);
                    $created++;
                }

                Permission::firstOrCreate(['name'=>$perm, 'guard_name'=>'web']);
            }

            // 🔥 PRUNE: hapus resource (dan permission) yang tidak ada lagi di routes
            if ($pruneOrphans) {
                $orphans = Resource::whereNotIn('permission_name', $seenPerms)->get();
                if ($orphans->isNotEmpty()) {
                    // hapus permission terlebih dahulu (Spatie akan detach dari roles)
                    Permission::whereIn('name', $orphans->pluck('permission_name'))->delete();
                    // lalu hapus record resources
                    Resource::whereIn('id', $orphans->pluck('id'))->delete();
                    $deleted = $orphans->count();
                }
            }
        });

        // refresh cache & (opsional) auto-grant superadmin
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        // if ($super = Role::where('name','superadmin')->first()) {
        //     $super->syncPermissions(Permission::pluck('name'));
        // }

        return compact('created','updated','deleted');
    }
}
