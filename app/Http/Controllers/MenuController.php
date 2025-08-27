<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::whereNull('parent_id')
            ->with('children.children') // 2 level, tambah jika perlu
            ->orderBy('order')
            ->get();

        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::orderBy('title')->get();
        return view('setting.menus.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:100',
            'icon'  => 'nullable|string|max:100',
            'route_name' => 'nullable|string|max:150',
            'url'   => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'permission_name' => 'nullable|string|max:191',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        Menu::create($data);

        return redirect()->route('menus.index')->with('success','Menu dibuat.');
    }

    public function edit(Menu $menu)
    {
        $parents = Menu::where('id','!=',$menu->id)->orderBy('title')->get();
        return view('setting.menus.edit', compact('menu','parents'));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'title' => 'required|string|max:100',
            'icon'  => 'nullable|string|max:100',
            'route_name' => 'nullable|string|max:150',
            'url'   => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'permission_name' => 'nullable|string|max:191',
        ]);
        $data['is_active'] = $request->boolean('is_active');

        // kamu masih bisa edit is_system menu hasil sync
        $menu->update($data);

        return redirect()->route('menus.index')->with('success','Menu diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back()->with('success','Menu dihapus.');
    }
}
