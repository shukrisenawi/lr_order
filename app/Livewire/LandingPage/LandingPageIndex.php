<?php

namespace App\Livewire\LandingPage;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LandingPage;

class LandingPageIndex extends Component
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
        $landingPage = LandingPage::findOrFail($id);
        $landingPage->delete();

        session()->flash('message', 'Landing page deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $landingPage = LandingPage::findOrFail($id);
        $landingPage->status = $landingPage->status === 'published' ? 'draft' : 'published';
        $landingPage->save();

        session()->flash('message', 'Landing page status updated successfully.');
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    public function render()
    {
        $landingPages = LandingPage::with('bisnes')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%')
                        ->orWhereHas('bisnes', function ($subQuery) {
                            $subQuery->where('nama_bisnes', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.landing-page.landing-page-index', compact('landingPages'));
    }
}