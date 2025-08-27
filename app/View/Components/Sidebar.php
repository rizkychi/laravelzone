<?php

namespace App\View\Components;

use App\Models\Menu;
use App\Services\MenuTreeService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private MenuTreeService $menus)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $tree = auth()->check() ? $this->menus->forUser(auth()->user()) : [];
        return view('components.sidebar', compact('tree'));
    }
}
