<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $pelangganRole = Role::where('name', 'Pelanggan')->first();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Pelanggan User',
            'email' => 'pelanggan@example.com',
            'password' => bcrypt('password'), // Gantilah password dengan yang lebih aman
            'role_id' => $pelangganRole->id,
        ]);
    }
}
