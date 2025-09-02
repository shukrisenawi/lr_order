<?php

namespace App\Livewire\LandingPage;

use Livewire\Component;
use App\Models\LandingPage;
use App\Models\Bisnes;
use Illuminate\Support\Str;

class LandingPageForm extends Component
{
    public $landingPage;
    public $bisnes_id = '';
    public $title = '';
    public $slug = '';
    public $content = '';
    public $status = 'draft';
    public $meta_title = '';
    public $meta_description = '';
    public $template = 'default';
    public $isEdit = false;

    protected function rules()
    {
        $rules = [
            'bisnes_id' => 'required|exists:bisnes,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:landing_page,slug',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'template' => 'required|string|max:50',
        ];

        // If editing, exclude current record from slug uniqueness check
        if ($this->isEdit && $this->landingPage) {
            $rules['slug'] = 'required|string|max:255|unique:landing_page,slug,' . $this->landingPage->id;
        }

        return $rules;
    }

    protected $messages = [
        'title.required' => 'Tajuk diperlukan.',
        'title.string' => 'Tajuk mestilah teks.',
        'title.max' => 'Tajuk maksimum 255 aksara.',
        'slug.required' => 'Slug diperlukan.',
        'slug.string' => 'Slug mestilah teks.',
        'slug.max' => 'Slug maksimum 255 aksara.',
        'slug.unique' => 'Slug sudah digunakan.',
        'content.required' => 'Kandungan diperlukan.',
        'content.string' => 'Kandungan mestilah teks.',
        'status.required' => 'Status diperlukan.',
        'status.in' => 'Status tidak sah.',
        'meta_title.string' => 'Meta tajuk mestilah teks.',
        'meta_title.max' => 'Meta tajuk maksimum 255 aksara.',
        'meta_description.string' => 'Meta penerangan mestilah teks.',
        'meta_description.max' => 'Meta penerangan maksimum 500 aksara.',
        'template.required' => 'Template diperlukan.',
        'template.string' => 'Template mestilah teks.',
        'template.max' => 'Template maksimum 50 aksara.',
    ];

    public function mount($landingPage = null)
    {
        if ($landingPage) {
            $this->landingPage = $landingPage;
            $this->isEdit = true;
            $this->bisnes_id = $landingPage->bisnes_id;
            $this->title = $landingPage->title;
            $this->slug = $landingPage->slug;
            $this->content = $landingPage->content;
            $this->status = $landingPage->status;
            $this->meta_title = $landingPage->meta_title ?? '';
            $this->meta_description = $landingPage->meta_description ?? '';
            $this->template = $landingPage->template;
        } else {
            // Set default business for new landing pages
            $defaultBisnes = Bisnes::first();
            if ($defaultBisnes) {
                $this->bisnes_id = $defaultBisnes->id;
            }
        }
    }

    public function updatedTitle()
    {
        if (!$this->isEdit || empty($this->slug)) {
            $baseSlug = Str::slug($this->title);
            $slug = $baseSlug;
            $counter = 1;

            // Check for uniqueness, excluding current record if editing
            while (LandingPage::where('slug', $slug)
                ->when($this->isEdit && $this->landingPage, function ($query) {
                    return $query->where('id', '!=', $this->landingPage->id);
                })
                ->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $this->slug = $slug;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'bisnes_id' => $this->bisnes_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'status' => $this->status,
            'meta_title' => $this->meta_title ?: null,
            'meta_description' => $this->meta_description ?: null,
            'template' => $this->template,
        ];

        if ($this->isEdit) {
            $this->landingPage->update($data);
            session()->flash('success', 'Landing page berjaya dikemaskini.');
        } else {
            LandingPage::create($data);
            session()->flash('success', 'Landing page berjaya dicipta.');
        }

        return redirect()->route('landing-page.index');
    }

    public function render()
    {
        $bisnes = Bisnes::all();
        return view('livewire.landing-page.landing-page-form', compact('bisnes'));
    }
}