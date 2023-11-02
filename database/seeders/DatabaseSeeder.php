<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role AS Role;
use Spatie\Permission\Models\Permission AS Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        #TODO insert PermissionTableSeeder Data
        $this->call([
            PermissionTableSeeder::class,
        ]);

        $sadmin = User::create([
            'username' => 'superadmin',
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'superadmin@test.com',
            'password' => 'secret',
        ]);

        $role = Role::create(['name' => 'Superadmin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $sadmin->assignRole([$role->id]);

        $admin = User::create([
            'username' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@test.com',
            'password' => 'secret',
        ]);

        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);

        $Clients =  [User::create([
            'username' => 'user',
            'firstname' => 'User',
            'lastname' => 'User',
            'email' => 'user@test.com',
            'password' => '123456',
        ]),
        User::create([
            'username' => 'userdua',
            'firstname' => 'User',
            'lastname' => 'Dua',
            'email' => 'userdua@test.com',
            'password' => '123456',
        ]),
        User::create([
            'username' => 'usertiga',
            'firstname' => 'User',
            'lastname' => 'Tiga',
            'email' => 'usertiga@test.com',
            'password' => '123456',
        ]),
    ];

        $role = Role::create(['name' => 'Client']);
        foreach ($Clients as $Client) {
            $permissions = Permission::where('id', '>',8)->pluck('id','id')->all();
            $role->syncPermissions($permissions);
            $Client->assignRole([$role->id]);
        }
    }
}
