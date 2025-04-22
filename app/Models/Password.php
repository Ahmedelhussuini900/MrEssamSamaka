<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Password extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'password',
        'used_by',
        'is_active',
        'expires_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime'
    ];

    // Relationship with Months through pivot
    public function months()
    {
        return $this->belongsToMany(Month::class, 'password_months')
                    ->withTimestamps();
    }

    // Relationship with User who used the password
    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    // Scope for active passwords
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for unused passwords
    public function scopeUnused($query)
    {
        return $query->whereNull('used_by');
    }

    // Scope for unexpired passwords
    public function scopeValid($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }
}
