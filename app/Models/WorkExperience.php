<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = [
        'user_id',
        'company',
        'job_title',
        'department',
        'start_date',
        'end_date',
        'is_current',
        'job_description',
        'company_logo',
    ];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
