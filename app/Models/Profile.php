<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'profile_photo',
        'date_of_birth',
        'nationality',
        'address',
        'phone_number',
        'email',
        'biography',
        'linkedin',
        'github',
        'facebook',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
