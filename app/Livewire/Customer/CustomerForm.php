<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class CustomerForm extends Component
{
    public function mount()
    {
        $selectedBisnes = \App\Models\Bisnes::find(session('selected_bisnes_id'));
        if (!$selectedBisnes || $selectedBisnes->type_id != 1) {
            return redirect()->route('dashboard');
        }
    }

    public function render()
    {
        return view('livewire.customer.customer-form');
    }
}
