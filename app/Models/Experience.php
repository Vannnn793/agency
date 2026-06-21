<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'candidate_id',
        'position',
        'company',
        'start_date',
        'end_date',
        'description',
    ];

    public function candidate()
{
    return $this->belongsTo(Candidates::class, 'candidate_id');
}
}