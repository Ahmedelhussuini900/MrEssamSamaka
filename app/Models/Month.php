<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Month extends Model
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

    // Relationship with Lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    // Relationship with Passwords through pivot
    public function passwords()
    {
        return $this->belongsToMany(Password::class, 'password_months')
                    ->withTimestamps();
    }

    // Scope for active months
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered months
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
