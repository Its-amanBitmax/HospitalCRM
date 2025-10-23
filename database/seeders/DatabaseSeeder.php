<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Admin::create([
            'name' => 'Super Admin',
            'email' => 'aman.profficial@gmail.com',
            'password' => Hash::make('am_2006@an'),
            'role' => 'super_admin',
            'permission' => 'all',
        ]);
    }
}
