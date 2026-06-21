<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    protected $fillable = ['name'];

    public function candidates(): BelongsToMany
    {
        return $this->belongsToMany(
            Candidates::class,
            'candidate_skill',
            'skill_id',
            'candidate_id'
        );
    }

    public function jobPostings(): BelongsToMany
    {
        return $this->belongsToMany(
            JobPosting::class,
            'job_posting_skill',
            'skill_id',
            'job_posting_id'
        );
    }
}