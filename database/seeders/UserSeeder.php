<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@NexaMart.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Normal User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@NexaMart.com',
            'password' => Hash::make('user123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Create another admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@NexaMart.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Users created successfully!');
        $this->command->info('');
        $this->command->info('🔐 Admin Credentials:');
        $this->command->info('   Email: admin@NexaMart.com');
        $this->command->info('   Password: admin123');
        $this->command->info('');
        $this->command->info('👤 Normal User Credentials:');
        $this->command->info('   Email: user@NexaMart.com');
        $this->command->info('   Password: user123');
        $this->command->info('');
        $this->command->info('🔐 Super Admin Credentials:');
        $this->command->info('   Email: superadmin@NexaMart.com');
        $this->command->info('   Password: superadmin123');
    }
}