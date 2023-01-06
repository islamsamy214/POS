<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'full_name' => 'super admin',
            'email' => 'super_admin@app.com',
            'mobile_number' => '+201234567891',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ])->attachRole('admin');
        //end of initial user

        $users = User::factory()->count(100)->create();
        foreach ($users as $user) {
            $user->attachRole('client');
        }
        // end of user seeder
    }
}
