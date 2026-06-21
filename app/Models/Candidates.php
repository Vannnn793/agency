<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidates extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'email',
        'date_of_birth',
        'gender',
        'headline',
        'about',
        'location',
        'expected_salary',
        'availability',
        'photo',
        'status',
    ];

    protected $with = ['skills'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(
            Skill::class,
            'candidate_skill',
            'candidate_id',
            'skill_id'
        );
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class, 'candidate_id');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class, 'candidate_id');
    }

    public function placements(): HasMany
    {
        return $this->hasMany(Placement::class, 'candidate_id');
    }

    public function getExperienceYearsAttribute(): float
    {
        $years = 0.0;
        foreach ($this->experiences as $exp) {
            $start = \Carbon\Carbon::parse($exp->start_date);
            $end = $exp->end_date ? \Carbon\Carbon::parse($exp->end_date) : now();
            $years += $start->diffInDays($end) / 365.25;
        }
        return round($years, 1);
    }
}