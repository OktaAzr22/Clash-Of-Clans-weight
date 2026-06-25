<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmptyState extends Component
{
    public $title;
    public $message;
    public $icon;

    public function __construct(
        $title = 'Belum Ada Data',
        $message = 'Data tidak ditemukan.',
        $icon = 'fa-solid fa-layer-group'
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->icon = $icon;
    }

    public function render(): View|Closure|string
    {
        return view('components.empty-state');
    }
}