<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $statusFilter = '';

    protected $queryString = ['search', 'statusFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
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
        $invoice = Invoice::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $invoice->delete();

        session()->flash('message', 'Invoice deleted successfully.');
        $this->dispatch('invoice-deleted');
    }

    public function updateStatus($id, $status)
    {
        $invoice = Invoice::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $invoice->update(['status' => $status]);

        session()->flash('message', 'Invoice status updated successfully.');
    }

    public function render()
    {
        $invoices = Invoice::with(['bisnes', 'items'])
            ->whereHas('bisnes', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoice_no', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_penerima', 'like', '%' . $this->search . '%')
                        ->orWhere('no_tel', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.invoice.invoice-index', compact('invoices'));
    }
}
