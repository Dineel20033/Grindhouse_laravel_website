<?php

namespace App\Livewire;

use Livewire\Component;

class VideoPlayer extends Component
{
    public $src;
    public $playerClass = '';

    public function mount($src, $playerClass = '')
    {
        $this->src = $src;
        $this->playerClass = $playerClass;
    }

    public function render()
    {
        return view('livewire-views.video-player');
    }
}
