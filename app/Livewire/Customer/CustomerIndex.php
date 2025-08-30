<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function delete($id)
    {
        $customer = Customer::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $customer->delete();

        session()->flash('message', 'Customer deleted successfully.');
        $this->dispatch('prospect-deleted');
    }

    public function render()
    {
        $customer = Customer::where('bisnes_id', session('selected_bisnes_id'))->with('bisnes')
            ->whereHas('bisnes', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('gelaran', 'like', '%' . $this->search . '%')
                        ->orWhere('no_tel', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.customer.customer-index', compact('customer'));
    }
}
