<?php
namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends \Illuminate\Database\Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234567890'),
        ]);
    }
}
