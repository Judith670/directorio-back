<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Tymon\JWTAuth\Facades\JWTAuth as JWT;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // $role3 = Role::create(['name' => 'Super-Admin']);

        $user = User::create([
            'name' => 'Judith',
            'email' => 'judith@gmail.com',
            'password' => bcrypt('Judith1234')
        ]);

        // $user->assignRole($role3);
    }
}
