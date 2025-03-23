<?php

namespace Database\Seeders;

use App\Models\Client;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $this->call(\Database\Seeders\Admin\AdminSeeder::class);
        $this->call(\Database\Seeders\Admin\RoleAndPermissionSeeder::class);

        // Client
        $this->call(\Database\Seeders\Client\AccountSeeder::class);
    }
}
