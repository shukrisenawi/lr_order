<?php

namespace App\Livewire\LandingPage;

use Livewire\Component;
use App\Models\LandingPage;
use Illuminate\Support\Str;

class LandingPageForm extends Component
{
    public $landingPage;
    public $title = '';
    public $slug = '';
    public $content = '';
    public $status = 'draft';
    public $meta_title = '';
    public $meta_description = '';
    public $template = 'default';
    public $isEdit = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:landing_page,slug',
        'content' => 'required|string',
        'status' => 'required|in:draft,published',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'template' => 'required|string|max:50',
    ];

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
            $this->title = $landingPage->title;
            $this->slug = $landingPage->slug;
            $this->content = $landingPage->content;
            $this->status = $landingPage->status;
            $this->meta_title = $landingPage->meta_title ?? '';
            $this->meta_description = $landingPage->meta_description ?? '';
            $this->template = $landingPage->template;

            // Update validation rules for edit mode
            $this->rules['slug'] = 'required|string|max:255|unique:landing_page,slug,' . $landingPage->id;
        }
    }

    public function updatedTitle()
    {
        if (!$this->isEdit || empty($this->slug)) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
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
        return view('livewire.landing-page.landing-page-form');
    }
}