<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'anggota',
            'artikel',
            'pengajar',
            'galeri'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // create role
        $administrator = Role::firstOrCreate(['name' => 'Administrator']);
        $editor = Role::firstOrCreate(['name' => 'Editor']);

        // asssign perrmission ke role
        $administrator->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['artikel']);

        // assidn role ke user
        $userAdministrator = User::firstOrCreate([
            'email' => 'adminstratorbtkvunair@gmail.com',
            'role'  => 'Administrator',
            'nomor_telepon' => null,
        ], [
            'name'     => 'Adminstrator BTKV UNAIR',
            'password' => Hash::make(env('SALT_PASSWORD') . "administratorpasswordbtkvunair2025#" . env('SALT_PASSWORD')),
        ]);

        $userAdministrator->assignRole('Administrator');

        $userEditor = User::firstOrCreate([
            'email' => 'editobtkvunairr@gmail.com',
            'role'  => 'Editor',
            'nomor_telepon' => null,
        ], [
            'name'     => 'Editor BTKV UNAIR',
            'password' => Hash::make(env('SALT_PASSWORD') . "editorpasswordbtkvunair2025#" . env('SALT_PASSWORD')),
        ]);

        $userEditor->assignRole('Editor');
    }
}
