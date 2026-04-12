<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => config('admin.seed_email')],
            [
                'name' => config('admin.seed_name'),
                'password' => Hash::make(config('admin.seed_password')),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        $this->call(StyleSeeder::class);
    }
}
