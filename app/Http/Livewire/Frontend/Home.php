<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use Cart;

class Home extends Component
{
    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];
    public function render()
    {
        return view('livewire.frontend.home', [])->extends('livewire.frontend.master');
    }
}
