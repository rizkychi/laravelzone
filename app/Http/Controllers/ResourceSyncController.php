<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResourceSyncService;
use Illuminate\Http\RedirectResponse;

class ResourceSyncController extends Controller
{
    public function store(ResourceSyncService $service): RedirectResponse
    {
        $res = $service->sync();
        return back()->with('success', "Sync: {$res['created']} dibuat, {$res['updated']} diupdate, {$res['deleted']} dihapus.");
    }
}
