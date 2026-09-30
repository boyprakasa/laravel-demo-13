<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavMenu extends Component
{
    public array $items;

    /**
     * Create a new component instance.
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function isActive(array $item): bool
    {
        // Jika diberikan activeWhen khusus, gunakan itu
        if (!empty($item['activeWhen'])) {
            return request()->is($item['activeWhen']);
        }

        // Jika diberikan nama route, periksa apakah route saat ini cocok
        if (!empty($item['route'])) {
            return request()->routeIs($item['route']);
        }

        // Fallback: periksa URL yang diberikan (jika ada)
        if (!empty($item['url'])) {
            return request()->is($item['url'] . '*');
        }

        return false;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav-menu');
    }
}
