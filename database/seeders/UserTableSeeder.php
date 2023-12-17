<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        for ($i=1; $i < 50; $i++) {
            $user = User::create([
                'name' => 'Test '.$i,
                'lastname' => 'Test '.$i,
                'direction' => 'Test '.$i,
                'email' => 'test'.$i.'@test.com',
                'phone' => 'Test '.$i,
                'email_verified_at' => null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
            $role = Role::where('id', 4)->first();
            $permission = Permission::where('name', 'dashboard.index')->first();
            $user->syncRoles($role)->syncPermissions($permission);
        }
    }
}
