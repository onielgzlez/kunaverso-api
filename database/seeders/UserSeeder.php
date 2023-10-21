<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'username' => 'admin',
            'email_verified_at' => now(),
            'email' => 'admin@kunaverso.com',
            'password' => Hash::make('Kuna*.2023'),
        ]);

        \App\Models\AccessToken::create([
            'name' => 'kunaverso',
            'token' => '9d868ef5b9de09e4df4818482cbbd71ce7c7d38f86f91b47779cc973e1a0c7ce',
        ]);
        
        \App\Models\AccessToken::create([
            'name' => 'swagger',
            'token' => '12b43e576574f3bf7f166a9ea7b38902e046427c1f3d607c873c2e128e1edc94',
            'limit' => 10,
        ]);
    }
}
