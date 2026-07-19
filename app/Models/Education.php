<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'education';

    protected $fillable = [
        'user_id',
        'school_name',
        'degree',
        'department',
        'start_date',
        'end_date',
        'gpa',
        'status',
        'certificate_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
