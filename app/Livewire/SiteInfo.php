<?php

namespace App\Livewire;

use App\Models\SiteInfo as SiteInfoModel;
use Livewire\Component;

class SiteInfo extends Component
{
    public $info;

    public function mount()
    {
        $this->info = SiteInfoModel::first();
    }

    public function render()
    {
        return view('livewire.site-info', [
            'info' => $this->info,
        ]);
    }
}
