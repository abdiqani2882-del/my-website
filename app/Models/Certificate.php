<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'institution',
        'certificate_number',
        'issue_date',
        'expiry_date',
        'description',
        'file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
