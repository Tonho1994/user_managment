<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin=User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'phone' => '+525544159052',
            'email_verified_at' => now(),
            'password' => Hash::make('password123!'),
            'remember_token' => Str::random(10),
       ]);
        $admin->assignRole('admin');
        $admin=User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'phone' => '+525543459662',
            'email_verified_at' => now(),
            'password' => Hash::make('password123!'),
            'remember_token' => Str::random(10),
       ]);
        $admin->assignRole('user');
        User::factory(13)->create();

    }
}
