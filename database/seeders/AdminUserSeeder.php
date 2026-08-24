<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create (or update) the one admin account the client logs in with.
     *
     * Reads ADMIN_EMAIL / ADMIN_PASSWORD from .env so no credential is
     * committed to the repository. Safe to re-run: it updates the password
     * of the existing account rather than creating a duplicate.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command->warn(
                'Skipped: set ADMIN_EMAIL and ADMIN_PASSWORD in .env before running this seeder.'
            );

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Analise Roland',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info("Admin account ready: {$email}");
    }
}
