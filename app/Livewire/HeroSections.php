<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HeroSection;

class HeroSections extends Component
{
    public $sections = [];
    public $sectionKey;

    public function mount($sectionKey = 'home')
    {
        $this->sectionKey = $sectionKey;

        $this->sections = HeroSection::where('is_active', 1)
            ->where('section_key', $this->sectionKey)
            ->orderBy('display_order', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.hero-sections');
    }
}
