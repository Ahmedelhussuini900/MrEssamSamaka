<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationship with Users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Scope for active grades
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered grades
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
