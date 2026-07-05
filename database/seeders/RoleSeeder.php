<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed default roles and sync existing users from the legacy users.role column.
     */
    public function run(): void
    {
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('user', 'web');

        User::whereIn('role', ['admin', 'user'])
            ->get()
            ->each(function (User $user): void {
                $user->assignRole($user->role);
            });
    }
}
