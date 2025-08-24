<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'token',
        'is_active',
        'last_used_at',
        'expires_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    protected $hidden = [
        'token'
    ];

    /**
     * Generate a new API token
     */
    public static function generateToken(): string
    {
        return 'bms_' . Str::random(40);
    }

    /**
     * Create a new API token for a user
     */
    public static function createForUser($userId, $name, $expiresAt = null): self
    {
        return self::create([
            'user_id' => $userId,
            'name' => $name,
            'token' => self::generateToken(),
            'is_active' => true,
            'expires_at' => $expiresAt
        ]);
    }

    /**
     * Check if token is expired
     */
    public function isExpired(): bool
    {
        if (!$this->expires_at) {
            return false;
        }
        
        return $this->expires_at->isPast();
    }

    /**
     * Check if token is valid (active and not expired)
     */
    public function isValid(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for active tokens
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for valid tokens (active and not expired)
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Get masked token for display
     */
    public function getMaskedTokenAttribute(): string
    {
        if (!$this->token) {
            return '';
        }
        
        return substr($this->token, 0, 8) . '...' . substr($this->token, -8);
    }
}
