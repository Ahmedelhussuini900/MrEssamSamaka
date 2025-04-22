<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'month_id',
        'title',
        'video_url',
        'video_thumbnail',
        'video_duration',
        'is_premium',
        'is_featured',
        'is_active',
        'order',
        'description',
        'video_metadata',
        'has_exam',
        'exam_duration',
        'passing_score',
        'max_attempts',
        'exam_questions',
        'exam_settings',
        'views_count',
        'downloads_count',
        'rating',
        'rating_count',
        'additional_data'
    ];

    protected $casts = [
        'video_metadata' => 'json',
        'exam_questions' => 'json',
        'exam_settings' => 'json',
        'additional_data' => 'json',
        'is_premium' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'has_exam' => 'boolean',
    ];

    // Relationship with Month
    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    // Scope for active lessons
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for featured lessons
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope for premium lessons
    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    // Scope for lessons with exams
    public function scopeWithExam($query)
    {
        return $query->where('has_exam', true);
    }

    // Helper method to increment views
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    // Helper method to increment downloads
    public function incrementDownloads()
    {
        $this->increment('downloads_count');
    }

    // Helper method to add rating
    public function addRating($rating)
    {
        $this->rating = (($this->rating * $this->rating_count) + $rating) / ($this->rating_count + 1);
        $this->rating_count++;
        $this->save();
    }
}
