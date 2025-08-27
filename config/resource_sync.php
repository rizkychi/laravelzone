<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Exclude Route Names
    |--------------------------------------------------------------------------
    | Semua route yang namanya diawali dengan ini akan di-skip.
    | Contoh: login, logout, password.reset, dll.
    */
    'exclude_name_prefixes' => [
        'login',
        'logout',
        'password.',
        'verification.',
        'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Exclude Controller Namespaces
    |--------------------------------------------------------------------------
    | Semua controller di namespace berikut tidak akan disinkron.
    */
    'exclude_controllers' => [
        'App\\Http\\Controllers\\Auth\\',
    ],

    /*
    |--------------------------------------------------------------------------
    | Exclude URI Prefixes
    |--------------------------------------------------------------------------
    | Semua route dengan prefix URI berikut akan diabaikan.
    */
    'exclude_uris' => [
        'sanctum',
        'telescope',
        '_ignition',
        'debugbar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Include Only Named Routes
    |--------------------------------------------------------------------------
    | Kalau true, hanya route yang punya nama (route name) yang disinkronkan.
    | Kalau false, route tanpa nama akan tetap ikut (permission_name = action).
    */
    'named_routes_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Prune Orphans
    |--------------------------------------------------------------------------
    | Kalau true, resource & permission yang tak ditemukan lagi akan dihapus.
    */
    'prune_orphans' => true,
];
