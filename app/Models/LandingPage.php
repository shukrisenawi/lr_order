<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LandingPage extends Model
{
    protected $table = 'landing_page';

    protected $fillable = [
        'bisnes_id',
        'title',
        'slug',
        'content',
        'status',
        'meta_title',
        'meta_description',
        'template',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function bisnes()
    {
        return $this->belongsTo(Bisnes::class);
    }

    // Automatically generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($landingPage) {
            if (empty($landingPage->slug)) {
                $landingPage->slug = Str::slug($landingPage->title);
            }
        });

        static::updating(function ($landingPage) {
            if ($landingPage->isDirty('title') && empty($landingPage->slug)) {
                $landingPage->slug = Str::slug($landingPage->title);
            }
        });
    }

    // Scope for published pages
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Get the URL for the landing page
    public function getUrlAttribute()
    {
        return route('landing-page.show', $this->slug);
    }
}
