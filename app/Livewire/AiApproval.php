<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class AiApproval extends Component
{
    public $activeTab = 'customers';
    public $customerCount = 0;
    public $invoiceCount = 0;

    protected $listeners = ['updateAiBadge' => 'updateAiBadge'];

    public function mount()
    {
        $this->updateCounts();
    }

    public function updateCounts()
    {
        $this->customerCount = Customer::where('bisnes_id', session('selected_bisnes_id'))
            ->where('create_by_ai', true)
            ->count();

        $this->invoiceCount = Invoice::where('bisnes_id', session('selected_bisnes_id'))
            ->where('create_by_ai', true)
            ->count();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updateAiBadge($count)
    {
        // This method is called when the badge is updated
        // The count is already updated in the approve methods
    }

    public function approveCustomer($id)
    {
        $customer = Customer::where('bisnes_id', session('selected_bisnes_id'))
            ->where('create_by_ai', true)
            ->findOrFail($id);

        $customer->update(['create_by_ai' => false]);

        $this->updateCounts();
        $this->dispatch('updateAiBadge', $this->customerCount + $this->invoiceCount);
        session()->flash('message', 'Customer approved successfully.');
    }

    public function approveInvoice($id)
    {
        $invoice = Invoice::where('bisnes_id', session('selected_bisnes_id'))
            ->where('create_by_ai', true)
            ->findOrFail($id);

        $invoice->update(['create_by_ai' => false]);

        $this->updateCounts();
        $this->dispatch('updateAiBadge', $this->customerCount + $this->invoiceCount);
        session()->flash('message', 'Invoice approved successfully.');
    }

    public function approveAllCustomers()
    {
        Customer::where('bisnes_id', session('selected_bisnes_id'))
            ->where('create_by_ai', true)
            ->update(['create_by_ai' => false]);

        $this->updateCounts();
        $this->dispatch('updateAiBadge', $this->customerCount + $this->invoiceCount);
        session()->flash('message', 'All customers approved successfully.');
    }

    public function approveAllInvoices()
    {
        Invoice::where('bisnes_id', session('selected_bisnes_id'))
            ->where('create_by_ai', true)
            ->update(['create_by_ai' => false]);

        $this->updateCounts();
        $this->dispatch('updateAiBadge', $this->customerCount + $this->invoiceCount);
        session()->flash('message', 'All invoices approved successfully.');
    }

    public function render()
    {
        $customers = Customer::where('bisnes_id', session('selected_bisnes_id'))
            ->where('create_by_ai', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $invoices = Invoice::where('bisnes_id', session('selected_bisnes_id'))
            ->where('create_by_ai', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.ai-approval', compact('customers', 'invoices'));
    }
}