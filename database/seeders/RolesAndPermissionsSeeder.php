<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ROLE MODEL
        $administration = Role::create(['name' => 'Administrador', 'description' => 'Supervisor del sistema']);
        $user_normal = Role::create(['name' => 'Usuario', 'description' => 'Usuario normal']);

        // DASHBOARD MODEL
        $dashboard = Permission::create(['name' => 'dashboard.index', 'description' => 'Ver dashboard']);

        // ROLE MODEL
        $role1 = Permission::create(['name' => 'roles.index', 'description' => 'Ver listado de rol']);
        $role2 = Permission::create(['name' => 'roles.create', 'description' => 'Crear rol']);
        $role3 = Permission::create(['name' => 'roles.edit', 'description' => 'Editar rol']);
        $role4 = Permission::create(['name' => 'roles.delete', 'description' => 'Eliminar rol']);

        // PERMISSION MODEL
        $permission1 = Permission::create(['name' => 'permissions.index', 'description' => 'Ver listado de permisos']);
        $permission2 = Permission::create(['name' => 'permissions.create', 'description' => 'Crear permiso']);
        $permission3 = Permission::create(['name' => 'permissions.edit', 'description' => 'Editar permiso']);
        $permission4 = Permission::create(['name' => 'permissions.delete', 'description' => 'Eliminar permiso']);

        // USER MODEL
        $user1 = Permission::create(['name' => 'users.index', 'description' => 'Ver listado de usuarios']);
        $user2 = Permission::create(['name' => 'users.show', 'description' => 'Ver usuario']);
        $user3 = Permission::create(['name' => 'users.create', 'description' => 'Crear usuario']);
        $user4 = Permission::create(['name' => 'users.edit', 'description' => 'Editar usuario']);
        $user5 = Permission::create(['name' => 'users.delete', 'description' => 'Eliminar usuario']);
        $user6 = Permission::create(['name' => 'users.permissions', 'description' => 'Dar permiso a usuario']);


        $profile1 = Permission::create(['name' => 'profile.index', 'description' => 'Ver perfil de usuario']);
        $profile2 = Permission::create(['name' => 'profile.edit', 'description' => 'Actualizar perfil de usuario']);

        $administration->syncPermissions([
            $dashboard,

            $role1,
            $role2,
            $role3,
            $role4,

            $permission1,
            $permission2,
            $permission3,
            $permission4,

            $user1,
            $user2,
            $user3,
            $user4,
            $user5,
            $user6,

            $profile1,
            $profile2
        ]);

        $user_normal->syncPermissions([
            $dashboard.
            $profile1,
            $profile2
        ]);


        $user_admin = User::create([
            'name' => 'Anthony Steven',
            'lastname' => 'Chica Mero',
            'direction' => 'La floresta',
            'email' => 'anthonychica.98@gmail.com',
            'phone' => '096 922 7858',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $user_admin->syncRoles([$administration]);
    }
}
