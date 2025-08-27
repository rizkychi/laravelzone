<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $q = Resource::query()
            ->when($request->search, fn($qq)=>$qq->where('name','like',"%{$request->search}%")
                ->orWhere('route_name','like',"%{$request->search}%")
                ->orWhere('action','like',"%{$request->search}%"))
            ->orderBy('name')
            ->paginate(20);

        return view('resources.index', ['resources' => $q]);
    }

    public function update(Request $request, Resource $resource)
    {
        $request->validate(['is_active' => ['required','boolean']]);

        $resource->update(['is_active' => $request->boolean('is_active')]);

        return back()->with('success', 'Status resource diperbarui.');
    }
}
