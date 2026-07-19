<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@portfolio.com',
            'password' => Hash::make('password'),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'full_name' => 'Administrator',
            'email' => 'admin@portfolio.com',
            'nationality' => 'Somali',
            'address' => 'Mogadishu, Somalia',
            'phone_number' => '+252 61 0000000',
            'biography' => 'This is the default administrator biography. Feel free to edit this profile to reflect your own information.',
        ]);
    }
}
